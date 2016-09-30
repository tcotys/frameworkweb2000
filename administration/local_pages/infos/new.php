<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'local_pages_article';
  
  $out_txt = "<h2>Enregistrement d\'une nouvelle page</h2>";
  $error = 0;
  if(isset($_POST['page_name']) && isset($_POST['url_titre']) && is_numeric($_POST['attached_to']) )
  {
    $page_name = setHtmlToMysql($_POST['page_name']);
    $url_titre = setHtmlToMysql($_POST['url_titre']);
    $attached_to = $_POST['attached_to'];
    try {
      $req = $bdd->prepare('INSERT INTO '.getTablePrefix().'pages(page_name, url_titre, attached_to, html_content, css_content, javascript_content) VALUES( :new_name, :new_url_titre, :new_attached_to, "", "", "")');
      $req->execute(array('new_name' => $page_name, 'new_url_titre' => $url_titre, 'new_attached_to' => $attached_to));
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
    header('Location: ../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>


