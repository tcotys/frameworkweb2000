<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'local_pages_article';
  
  $out_txt = '<h2>Enregistrement du code html de '.htmlspecialchars($_POST['page_name']).'</h2>';
  $error = 0;
  if(is_numeric($_POST['id']) && isset($_POST['html_content']) )
  {
    $html_content = setHtmlToMysql($_POST['html_content']);
    $id = $_POST['id'];
    try {
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'pages SET html_content=:nvhtml_content WHERE id=:oldId');
      $req->execute(array('oldId' => $id, 'nvhtml_content' => $html_content));
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
    header('Location: forms.php?page='.$id);
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
