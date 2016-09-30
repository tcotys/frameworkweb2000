<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'files_article';
  
  $out_txt = '<h2>Enregistrement de modification du document : '.htmlspecialchars($_POST['name']).'</h2>';
  $error = 0;
  if(is_numeric($_POST['file_id']) && isset($_POST['surname']) )
  {
    $id = $_POST['file_id'];
    $surname = htmlspecialchars($_POST['surname']);
    try {
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'files SET surname=:new_name WHERE id=:oldId');
      $req->execute(array('oldId' => $id, 'new_name' => $surname));
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
    header('Location: ../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
