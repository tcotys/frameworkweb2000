<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'notes_article';
  $out_txt = "<h2>Création d'une note</h2>";
  $error = 0;
  if(isset($_POST['note_name']) )
  {
    $note_name = setHtmlToMysql($_POST['note_name']);
    try {
      $req = $bdd->prepare('INSERT INTO '.getTablePrefix().'notes(note_name, note_content) VALUES(:new_name, "")');
      $req->execute(array('new_name' => $note_name));
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= $e->getMessage().'<br />';
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
    header('Location: ../../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
