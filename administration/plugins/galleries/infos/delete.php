<?php
  include_once('../../../includes/libraries_includer.inc.php');
  require_once('../handle_images.req.php');
  $_SESSION['anchored_page'] = 'galleries_article';
  
  $out_txt = "<h2>Suppression d\'une gallerie</h2>";
  $error = 0;
  
  if(isset($_POST['id'])) {
    $gal_id       = intval($_POST['id']);
    $gal_dir = "../../../../galleries/$gal_id/";
    
    $out_txt .= "<p>Removing images...";
    $out_txt .= deleteDir($gal_dir, false);
    $out_txt .= " Done.</p>";
    
    $out_txt .= "<p>Database update...";
    $req = $bdd->prepare('DELETE FROM '.getTablePrefix().'galleries WHERE id=:gal_id');
    $req->execute(array('gal_id'=>$gal_id));
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
