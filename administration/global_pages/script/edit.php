<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'global_pages_article';
  
  $out_txt = '<h2>Enregistrement du code global de '.htmlspecialchars($_POST['page_name']).'</h2>';
  $error = 0;
  if(isset($_POST['html_content']) and is_numeric($_POST['id']))
  {
    $out_txt .= "<p>Tentative d'enregistrement...</p>";
    $html_content = setHtmlToMysql($_POST['html_content']);
    $page_id = $_POST['id'];
    try {
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'info SET content=:nvhtml_content WHERE id=:page_id');
      $req->execute(array('nvhtml_content' => $html_content, 'page_id' => $page_id));
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
    header('Location: forms.php?page='.$page_id);
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
