<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'notes_article';
  $out_txt = '<h2>Suppression d\'une note</h2>';
  $error = 0;
  if(is_numeric($_POST['note']) )
  {
    $page_id = $_POST['note'];
    try {
      $req = $bdd->prepare('DELETE FROM '.getTablePrefix().'notes WHERE id=:old_id');
      $req->execute(array( 'old_id' => $page_id));
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= $e->getMessage().'<br />';
    }
    $out_txt .= '<p>Suppression effectuée !</p>';
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
