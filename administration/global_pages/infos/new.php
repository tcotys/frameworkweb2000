<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'global_pages_article';
  
  $out_txt = "<h2>Enregistrement d\'une nouvelle page globale</h2>";
  $error = 0;
  if(isset($_POST['page_name']) )
  {
    $page_name = setHtmlToMysql($_POST['page_name']);
    try {
      $req = $bdd->prepare('INSERT INTO '.getTablePrefix().'info(name, content) VALUES(:new_name,  "")');
      $req->execute(array('new_name' => $page_name));
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= $e->getMessage().'<br />';
    }
    echo "<p>Enregistrement réussit !</p>";
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
