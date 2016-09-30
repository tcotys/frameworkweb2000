<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'notes_article';
  $out_txt = '<h2>Modification de note</h2>';
  $error = 0;
  if(is_numeric($_POST['id']) && isset($_POST['note_name']) )
  {
    $id = $_POST['id'];
    $note_name = setHtmlToMysql($_POST['note_name']);
    try {
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'notes SET note_name=:new_note_name WHERE id=:old_id');
      $req->execute(array('new_note_name' => $note_name, 'old_id' => $id));
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= $e->getMessage().'<br />';
    }
    $out_txt .= '<p>Enregistrement réussit !</p>';
  }
  else
  {
    $error = 1;
    $out_txt .= "<p>Error : Wrong input parameters...</p>";
  }
  if ($error == 0) {
    $_SESSION['message'] = $out_txt;
    header('Location: ../../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
