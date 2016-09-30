<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'sounds_playlists_article';
  
  $out_txt = "<h2>Enregistrement d\'une nouvelle playlist</h2>";
  $error = 0;
  if(isset($_POST['name']) && isset($_POST['style'])) {
    $name         = setHtmlToMysql($_POST['name']);
    $design       = setHtmlToMysql($_POST['style']);
    $req = $bdd->prepare('INSERT INTO '.getTablePrefix().'sounds_playlists(name, style, tracks) 
                    VALUES(:name, :design, 0)');
    if($req->execute(array('name'=>$name,'design'=>$design))) {
      $out_txt .= "<p>Enregistrement réussit !</p>";
      $out_txt .= "<p>Création des dossiers associés à la gallerie.</p>";
    }
    else {
      $error = 1;
      $out_txt .= "<p>Error: Cannot save new gallery in database.</p>";
    }
  }
  else {
    $error = 1;
    $out_txt .= "<p>Error : Wrong input parameters...</p>";
  }
  
  if ($error == 0) {
    $_SESSION['message'] = $out_txt;
    header('Location: ../../../index.php');
  }
  else {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
