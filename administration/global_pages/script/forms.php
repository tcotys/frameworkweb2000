<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'global_pages_article';
  
  
  $save_message = addslashes($_SESSION['message']);
  $_SESSION['message'] = '';
  
  // ----- initialisation des plugins ----- //
  $backpath = '../../';
  include_once('../../includes/plugins_loader.inc.php');
  $setValues = array('text', 'texts', 'file', 'files');
?>
<!DOCTYPE html>
<html>
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
  $rep1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'info WHERE id=:page_id');
  $rep1->execute(array('page_id'=> $page_id));
  $don1 = $rep1->fetch()
  ?>
    <header id="articles_menu">
      <h1 class="unnumbered"><?php echo getSiteName(); ?></h1>
      <h2 class="unnumbered">Administration</h2>
      <nav>
        <ul>
          <li><a href="../../index.php">Pages Globales</a></li>
          <li class="selectedTab"><a href="#nocolor" onclick="hideColors();">No colors</a></li>
          <li><a href="#html" onclick="showHTML();">HTML</a></li>
          <li><a href="#css" onclick="showCSS();">CSS</a></li>
          <li><a href="#javascript" onclick="showJavascript();">JavaScript</a></li>
        </ul>
      </nav>
    </header>
    
    <section class="blockdisplay">
      <h1>Edition du contenu global : <?php echo getHtmlFromMysql($don1['name']);?></h1>
      <article id=formDiv>
        <ul id="edit_menu" class="edit_menu">
             <li><a href="#" onclick="document.getElementById('editForm').submit();">Enregistrer</a></li><!--
          --><li><a href="#" onclick="generatePreview('html_content_text', '<?php echo $don1['id'];?>', 'global');return false;">Prévisualiser</a></li><!--
          --><li>
            <a href="#">Insérer HTML</a>
            <ul id="menu_insert"></ul>
          </li><!--
          --><li>
            <a href="#">Insérer Script</a>
            <ul id="menu_insert_script"></ul>
          </li><!--
          --><li>
            <a href="#">Outils</a>
            <ul id="menu_outils"></ul>
          </li><!--
        --></ul>
        
        <form method="post" id="editForm" action="edit.php">
          <div>
            <textarea name="html_content" id="html_content_text" rows="20" cols="100"><?php echo getHtmlFromMysql($don1['content']);?></textarea>
            <div id="html_content_mirror"></div>
          </div>
          <input type=hidden name=id value="<?php echo $don1['id']; ?>" />
          <input type=hidden name=page_name value="<?php echo getHtmlFromMysql($don1['name']);?>" />
        </form>
      </article>
    </section>
<?php
}
else {
  echo '<p>Error: this page doesn\'t exist.</p>';
}
?> 
    <script type="text/javascript" src="../../javascript/dialogBoxes.js"></script>
    <script type="text/javascript" src="../../javascript/addMarkups.js"></script>
    <script type="text/javascript" src="../../javascript/shortcut.js"></script>
    <script type="text/javascript" src="../../javascript/scriptColor.js"></script>
    <script type="text/javascript" src="../../javascript/maximizeElem.js"></script>
    <?php
//       include '../../local_pages/infos/forms.php';
//       include '../../global_pages/infos/forms.php';
      
      foreach($PluginsInfo as $plugin) {
        if($plugin['mysql_installed']) {
          if(in_array($plugin['buttons_type'], $setValues) && in_array($plugin['global_load_type'], $setValues)) {
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
      // ----- Aides dynamiques à la rédaction... ----- //
      <?php
        foreach($PluginsInfo as $plugin) {
          if($plugin['mysql_installed']) {
            if(in_array($plugin['buttons_type'], $setValues) && in_array($plugin['global_load_type'], $setValues)) {
              if($plugin['global_load_type'] == 'text') {
                echo $plugin['global_load'];
              }
              elseif($plugin['global_load_type'] == 'texts') {
                foreach($plugin['global_load'] as $buttons_text) {
                  echo $buttons_text;
                }
              }
              if($plugin['global_load_type'] == 'file') {
                include '../../'.$plugin['global_load'];
              }
              elseif($plugin['global_load_type'] == 'files') {
                foreach($plugin['global_load'] as $buttons_file) {
                  include '../../'.$buttons_file;
                }
              }
            }
          }
        }
      ?>
      
      
      // ----- Script pour la coloration du code ----- //
      var scriptColor = 'none'; 
      function hideColors() {
        unsetMirror('html_content_text', 'html_content_mirror', 'javascript');
        unsetMirror('html_content_text', 'html_content_mirror', 'css');
        unsetMirror('html_content_text', 'html_content_mirror', 'html');
        scriptColor = 'none'; }
      function showCSS() {
        unsetMirror('html_content_text', 'html_content_mirror', 'javascript');
        unsetMirror('html_content_text', 'html_content_mirror', 'css');
        unsetMirror('html_content_text', 'html_content_mirror', 'html');
        setMirror('html_content_text', 'html_content_mirror', 'css');
        scriptColor = 'css'; }
      function showHTML() {
        unsetMirror('html_content_text', 'html_content_mirror', 'javascript');
        unsetMirror('html_content_text', 'html_content_mirror', 'css');
        unsetMirror('html_content_text', 'html_content_mirror', 'html');
        setMirror('html_content_text', 'html_content_mirror', 'html');
        scriptColor = 'html'; }
      function showJavascript() {
        unsetMirror('html_content_text', 'html_content_mirror', 'javascript');
        unsetMirror('html_content_text', 'html_content_mirror', 'css');
        unsetMirror('html_content_text', 'html_content_mirror', 'html');
        setMirror('html_content_text', 'html_content_mirror', 'javascript');
        scriptColor = 'javascript'; }

      // ----- Extend the textarea ----- //
      maximizeElem(document.getElementById('html_content_text'));
      document.getElementsByTagName("BODY")[0].onresize = function () {
        maximizeElem(document.getElementById('html_content_text'));
        if (scriptColor != 'none') {
          setMirror('html_content_text', 'html_content_mirror', scriptColor);}};
      
      // ----- Aide pour des information d'url ----- //
      function getImgAdress(adress) {
          alert('Url de l\'image : ' + adress);}
      function getImgHtml(adress, name) {
          alert('<img src="' + adress + '" alt="' + name + '" />'); }
      function getPageLink(adress) {
          alert('<a href="index.php?page=' + adress + '">Texte du lien</a>'); }
      
          
      // ----- Shortcut used to save documents ----- //
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
      
      showSaveMessage();
      
      // ----- Mise à jour des onglets du menu... ----- //
      function updateSelectedTab() {
        var it2;
        var oldSelectedTab = document.getElementsByTagName("li");
        for(it2 = 0; it2 < oldSelectedTab.length; it2++) {
          oldSelectedTab[it2].className = oldSelectedTab[it2].className.replace(/selectedTab/i, "");
        }
          
        var nav_links = document.getElementsByTagName("a");
        var it1;
        for (it1 = 0; it1 < nav_links.length; it1++) {
          link_anchor = nav_links[it1].href.split("#");
          link_anchor = '#' + link_anchor[link_anchor.length - 1];
          if (link_anchor  == location.hash) {
            nav_links[it1].parentNode.className = nav_links[it1].className + " selectedTab";
          }
        }
      }
      
//       updateSelectedTab();
      if ("onhashchange" in window) { // event supported? : Google Chrome 5, Safari 5, Opera 10.60, Firefox 3.6 and Internet Explorer 8
        window.onhashchange = function () {
//           hashChanged(window.location.hash);
          updateSelectedTab();
        }
      }
      else { // event not supported:
        var storedHash = window.location.hash;
        window.setInterval(function () {
          if (window.location.hash != storedHash) {
            storedHash = window.location.hash;
//             hashChanged(storedHash);
            updateSelectedTab();
          }
        }, 100);
      }
    </script>
  </body>
</html>
