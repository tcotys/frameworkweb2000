<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'images_article';
  
  $out_txt = '<h2>Enregistrement de modification de l\'image : '.htmlspecialchars($_POST['name']).'</h2>';
  $error = 0;
  if(is_numeric($_POST['id']) && isset($_POST['img_type']) && isset($_POST['img_name']) )
  {
    $id = $_POST['id'];
    $name = $_POST['img_name'];
    $type = $_POST['img_type'];
    try {
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'img SET name=:new_name, type=:new_type WHERE id=:oldId');
      $req->execute(array('oldId' => $id, 'new_name' => $name, 'new_type' => $type));
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
