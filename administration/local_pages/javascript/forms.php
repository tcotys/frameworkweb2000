<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'local_pages_article';
  
  $save_message = addslashes($_SESSION['message']);
  $_SESSION['message'] = '';
  
  // ----- initialisation des plugins ----- //
  $backpath = '../../';
  include_once('../../includes/plugins_loader.inc.php');
  $setValues = array('text', 'texts', 'file', 'files');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>Administration du site <?php echo getSiteName(); ?></title>
    <link rel="stylesheet" type="text/css" href="../../style.css">
  </head>
  <body>
<?php
if(is_numeric($_GET['page']))
{
  $page_id = $_GET['page'];
  $rep1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'pages WHERE id=:page_id');
  $rep1->execute(array('page_id'=>$page_id));
  $don1 = $rep1->fetch()
  ?>
    <header id="articles_menu">
      <h1 class="unnumbered"><?php echo getSiteName(); ?></h1>
      <h2 class="unnumbered">Administration</h2>
      <nav>
        <ul>
          <li><a href="../../index.php">Pages Locales</a></li>
          <li><a href="#" onclick="askMove('../html/forms.php?page=<?php echo $page_id;?>', 'HTML');return false;">HTML</a></li>
          <li><a href="#" onclick="askMove('../css/forms.php?page=<?php echo $page_id;?>', 'CSS');return false;">CSS</a></li>
          <li class="selectedTab"><a href="#" onclick="return false;" >JavaScript</a></li>
        </ul>
      </nav>
    </header>
    <section class="blockdisplay">
      <h1>Edition du code javascript de : <?php echo getHtmlFromMysql($don1['page_name']);?></h1>
      <article id=formDiv>
          <ul id="edit_menu" class="edit_menu">
               <li><a href="#" onclick="document.getElementById('editForm').submit();">Enregistrer</a></li><!--
            --><li><a href="#" onclick="generatePreview('javascript_content_text', '<?php echo $don1['id'];?>', 'local-javascript');return false;">Prévisualiser</a></li><!--
            --><li><a href="#" onclick="showEditPageInfoForm(<?php echo $page_id.", '".$don1['page_name']."', '".$don1['url_titre']."', '".$don1['attached_to']."'"; ?>);">Info</a></li><!--
            --><li>
              <a href="#">Insérer</a>
              <ul id="menu_insert"></ul>
            </li><!--
            --><li>
              <a href="#">Outils</a>
              <ul id="menu_outils"></ul>
            </li><!--
          --></ul>
        <form method="post" id="editForm" action="edit.php">
          <div>
            <textarea name="javascript_content" id="javascript_content_text" rows="20" cols="100"><?php echo getHtmlFromMysql($don1['javascript_content']);?></textarea>
            <div id="javascript_content_mirror"></div>
          </div>
          <br />
          <input type=hidden name=id value="<?php echo $don1['id']; ?>" />
          <input type=hidden name=page_name value="<?php echo getHtmlFromMysql($don1['page_name']);?>" />
        </form>
      </article>
    </section>
    <script type="text/javascript" src="../../javascript/scriptColor.js"></script>
    <script type="text/javascript" src="../../javascript/shortcut.js"></script>
    <script type="text/javascript" src="../../javascript/addMarkups.js"></script>
    <script type="text/javascript" src="../../javascript/dialogBoxes.js"></script>
    <script type="text/javascript" src="../../javascript/scrollOnForms.js"></script>
    <script type="text/javascript" src="../../javascript/maximizeElem.js"></script>
    <?php
//       include '../../local_pages/infos/forms.php';
//       include '../../global_pages/infos/forms.php';
      
      foreach($PluginsInfo as $plugin) {
        if($plugin['mysql_installed']) {
          if(in_array($plugin['buttons_type'], $setValues) && in_array($plugin['js_load_type'], $setValues)) {
            if($plugin['buttons_type'] == 'text') {
              echo $plugin['buttons'];
            }
            elseif($plugin['buttons_type'] == 'texts') {
              foreach($plugin['buttons'] as $buttons_text) {
                echo $buttons_text;
              }
            }
            if($plugin['buttons_type'] == 'file') {
              include '../../'.$plugin['buttons'];
            }
            elseif($plugin['buttons_type'] == 'files') {
              foreach($plugin['buttons'] as $buttons_file) {
                include '../../'.$buttons_file;
              }
            }
          }
        }
      }
    ?>
    <script type="text/javascript">
      <?php
        foreach($PluginsInfo as $plugin) {
          if(in_array($plugin['buttons_type'], $setValues) && in_array($plugin['js_load_type'], $setValues)) {
            if($plugin['js_load_type'] == 'text') {
              echo $plugin['js_load'];
            }
            elseif($plugin['js_load_type'] == 'texts') {
              foreach($plugin['js_load'] as $buttons_text) {
                echo $buttons_text;
              }
            }
            if($plugin['js_load_type'] == 'file') {
              include '../../'.$plugin['js_load'];
            }
            elseif($plugin['js_load_type'] == 'files') {
              foreach($plugin['js_load'] as $buttons_file) {
                include '../../'.$buttons_file;
              }
            }
          }
        }
      ?>
      // ----- Etent le textarea ----- //
      maximizeElem(document.getElementById('javascript_content_text'));
      document.getElementsByTagName("BODY")[0].onresize = function () {maximizeElem(document.getElementById('javascript_content_text')); setMirror('javascript_content_text', 'javascript_content_mirror', 'html');};

      // ----- Met des couleurs aux scripts ----- //
      setMirror('javascript_content_text', 'javascript_content_mirror', 'javascript');
      
      // ----- Quelques raccourcis ----- //
      function getImgAdress(adress) {
        alert('Url de l\'image : ' + adress); }
      function getImgHtml(adress, name) {
        alert('<img src="' + adress + '" alt="' + name + '" />'); }
      function getPageLink(adress) {
        alert('<a href="index.php?page=' + adress + '">Texte du lien</a>') }
      
      // ----- Pour les déplacements vers une autre page ----- //
      function getFolder() {
        var localFolder = window.location.href;
        if (~localFolder.indexOf('index')) { //~x fait -(x+1)
          localFolder  = localFolder.substring(0, localFolder.indexOf('index.php')); }
        if (~localFolder.indexOf('#')) { //~x fait -(x+1)
          localFolder  = localFolder.substring(0, localFolder.indexOf('#')); }
        return localFolder;
      }
      function askMove(redirection, language) {
        if(confirm("Voulez-vous éditer le " + language + " de la page ?\n Les données non sauvegardées seront perdues.")) {
          var adresseLocale = getFolder();
//           window.location.href = adresseLocale + redirection;
          window.location.href = redirection;
        }
      }
      
      // Add shortcut to save document
      function saveDocument(e) {
        var ev = e || window.event;
        if (ev.preventDefault){
          ev.preventDefault();}
        ev.returnValue = false;
        document.forms["editForm"].submit();}
      shortcut.add("Meta+S",saveDocument);
      shortcut.add("Ctrl+S",saveDocument);
      function showSaveMessage() {
        var saveMessageText = '<?php echo $save_message; ?>';
        if (saveMessageText != '') {
          var saveMessageEnd = '<p><input type="button" value="Fermer" onclick="closeDialogBox(\'save_message\');" /></p>'; 
          openDialogBox('save_message', saveMessageText + saveMessageEnd);
        }
      }
      showSaveMessage();
    </script>
  <?php
}
else {
  echo 'Error';
}
?> 
  </body>
</html>
