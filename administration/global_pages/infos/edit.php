<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'global_pages_article';
  
  $out_txt = "<h2>Enregistrement d\'une nouvelle page</h2>";
  $error = 0;
  if(isset($_POST['gpage_name']) && is_numeric($_POST['gpage_id']) )
  {
    $id = $_POST['gpage_id'];
    try {
      $page_name = setHtmlToMysql($_POST['gpage_name']);
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'info SET name=:page_name WHERE id=:page_id');
      $req->execute(array('page_name' => $page_name, 'page_id' => $id));
    }
    catch (Exception $e) {
      $error = 1;
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
    header('Location: ../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
