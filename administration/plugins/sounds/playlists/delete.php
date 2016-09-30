<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'sounds_playlists_article';
  
  $out_txt = "<h2>Suppression d\'une gallerie</h2>";
  $error = 0;
  
  if(isset($_POST['playlist_id'])) {
    $playlist_id       = intval($_POST['playlist_id']);
    
    
    $out_txt .= "<p>Database update...";
    $req = $bdd->prepare('DELETE FROM '.getTablePrefix().'sounds_playlists WHERE id=:playlist_id');
    $req->execute(array('playlist_id'=>$playlist_id));
    $out_txt .= " Done.</p>";
    
    $out_txt .= "<p>Gallery Updated.</p>";
  }
  else {
    $error = 1;
    $out_txt .= "<p>Error: Wrong input parameters.</p>";
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
