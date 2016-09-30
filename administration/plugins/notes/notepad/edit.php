<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'notes_article';
  
  $out_txt = '<h2>Enregistrement de la note : '.htmlspecialchars($_POST['note_name']).'</h2>';
  $error = 0;
  if(is_numeric($_POST['id']) && isset($_POST['note_content']) )
  {
    $note_content = setHtmlToMysql($_POST['note_content']);
    $id = $_POST['id'];
    try {
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'notes SET note_content=:nvnote_content WHERE id=:oldId');
      $req->execute(array('oldId' => $id, 'nvnote_content' => $note_content));
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= "SQL...";
      $out_txt .= $e->getMessage()."<br />";
    }
    $out_txt .= "<p>Enregistrement réussit !</p>";
  }
  else
  {
    $error = 1;
    $out_txt .= "<p>Error : Wrong input parameters...</p>";
  }
  if ($error == 0) {
    $_SESSION['message'] = $out_txt;
    header('Location: forms.php?note='.$id);
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
