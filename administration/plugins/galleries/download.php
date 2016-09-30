<?php
  include_once('../../includes/libraries_includer.inc.php');
  require_once('handle_images.req.php');
  $_SESSION['anchored_page'] = 'galleries_article';

  $out_txt = "<h2>Creation d\'une archive de gallerie</h2>";
  $error = 0;
  
  if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $gal_id  = intval($_GET['id']);
    $rep1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'galleries WHERE id=:gal_id');
    $rep1->execute(array('gal_id'=>$gal_id));
    $don1 = $rep1->fetch();
    $gal_name = $don1['name'];
    
    $in_dir  = "../../../galleries/$gal_id/originals/";
    $zip_url = "../../../galleries/$gal_id/$gal_id.zip";
    $zip_file = new ZipArchive;
    if($zip_file->open($zip_url, ZipArchive::CREATE) === TRUE) {
      $out_txt .= "<p>Gallery ZIP file created !</p>";
      $out_txt .= copyDirectoryToZip($in_dir, $zip_file, '', true);
      $zip_file->close();
      $out_txt .= "<p>Images saved in ZIP file.</p>";
    }
    else {
      $error = 1;
      $out_txt .= "<p>Error: Cannot create ZIP file.</p>";
    }
  }
  else {
    $error = 1;
    $out_txt .= "<p>Error: Wrong input parameters.</p>";
  }
  
  if($error == 0) {
    $_SESSION['message'] = $out_txt;
    envoi_fichier ($gal_name.'.zip', $zip_url, 1);
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }

?>
