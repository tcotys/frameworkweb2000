<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'notes_article';
  
  $save_message = addslashes($_SESSION['message']);
  $_SESSION['message'] = '';
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>Administration du site <?php echo getSiteName(); ?></title>
    <link rel="stylesheet" type="text/css" href="../../../style.css">
  </head>
  <body>
<?php
if(is_numeric($_GET['note']))
{
  $note_id = $_GET['note'];
  $rep1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'notes WHERE id=:note_id');
  $rep1->execute(array('note_id'=>$note_id));
  $don1 = $rep1->fetch();
  ?>
    <header id="articles_menu">
      <h1 class="unnumbered"><?php echo getSiteName(); ?></h1>
      <h2 class="unnumbered">Administration</h2>
      <nav>
        <ul>
          <li><a href="../../../index.php">Bloc Notes</a></li>
        </ul>
      </nav>
    </header>
    
    <section class="blockdisplay">
      <h1>Edition de la note : <?php echo getHtmlFromMysql($don1['note_name']);?></h1>
      <article id=formDiv>
        <ul id="edit_menu" class="edit_menu">
             <li><a href="#" onclick="document.getElementById('editForm').submit();">Enregistrer</a></li><!--
          --><li><a href="#" onclick="showEditNoteInfoForm(<?php echo $note_id.", '".$don1['note_name']."'"; ?>);">Info</a></li><!--
        --></ul>
        <form method="post" id="editForm" action="edit.php">
          <input type=hidden name=id value="<?php echo $don1['id']; ?>" />
          <input type=hidden name=note_name value="<?php echo getHtmlFromMysql($don1['note_name']);?>" />
          <div>
            <textarea name="note_content" id="note_content_text" rows="20" cols="100"><?php echo getHtmlFromMysql($don1['note_content']);?></textarea>
          </div>
        </form>
      </article>
    </section>
    
    <script type="text/javascript" src="../../../javascript/dialogBoxes.js"></script>
<!--     <script type="text/javascript" src="../../../javascript/addMarkups.js"></script> -->
    <script type="text/javascript" src="../../../javascript/shortcut.js"></script>
    <script type="text/javascript" src="../../../javascript/scrollOnForms.js"></script>
    <script type="text/javascript" src="../../../javascript/maximizeElem.js"></script>
    <?php include "../infos/forms.php"; ?>
    <script type="text/javascript">
      
      
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

      // ----- Extend  textarea ----- //
      maximizeElem(document.getElementById('note_content_text'));
      document.getElementsByTagName("BODY")[0].onresize = function () {maximizeElem(document.getElementById('note_content_text'));};
    </script>
  <?php
}
else {
  echo 'Error';
}
?> 
  </body>
</html>
