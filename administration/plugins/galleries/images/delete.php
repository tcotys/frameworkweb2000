<?php
  include_once('../../../includes/libraries_includer.inc.php');
  require_once('../handle_images.req.php');
  $_SESSION['anchored_page'] = 'galleries_article';

  $out_txt = "<h2>Suppression d\'une image de la gallerie</h2>";
  $error = 0;
  if(isset($_POST['gal_id']) && isset($_POST['img_id'])) {
    $gal_id       = intval($_POST['gal_id']);
    $img_id       = intval($_POST['img_id']);
    
    $out_txt .= "<p>Removing miniature...</p>";
    $ini_dir  = "../../../../galleries/$gal_id/mini/";
    $tmp_dir  = "../../../../galleries/$gal_id/mini_tmp/";
    $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
    $out_txt .= clearDir($ini_dir, true, false);
    $out_txt .= copyWithoutAnImage($tmp_dir, $ini_dir, $img_id, true, false);
    $out_txt .= deleteDir($tmp_dir, false);
    $out_txt .= "<p>Done.</p>";
    
    $out_txt .= "<p>Removing large image...</p>";
    $ini_dir  = "../../../../galleries/$gal_id/large/";
    $tmp_dir  = "../../../../galleries/$gal_id/large_tmp/";
    $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
    $out_txt .= clearDir($ini_dir, true, false);
    $out_txt .= copyWithoutAnImage($tmp_dir, $ini_dir, $img_id, true, false);
    $out_txt .= deleteDir($tmp_dir, false);
    $out_txt .= "<p>Done.</p>";
    
    $out_txt .= "<p>Removing original...</p>";
    $ini_dir  = "../../../../galleries/$gal_id/originals/";
    $tmp_dir  = "../../../../galleries/$gal_id/originals_tmp/";
    $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
    $out_txt .= clearDir($ini_dir, true, false);
    $out_txt .= copyWithoutAnImage($tmp_dir, $ini_dir, $img_id, true, false);
    $out_txt .= deleteDir($tmp_dir, false);
    $out_txt .= "<p>Done.</p>";
    
    $out_txt .= "<p>Database update...";
    $rep1 = $bdd->query('SELECT * FROM '.getTablePrefix().'galleries WHERE id='.$gal_id);
    $don1 = $rep1->fetch();
    $nb_img = $don1['nb_img'];
    $nb_img--;
    $bdd->query('UPDATE '.getTablePrefix().'galleries SET nb_img='.$nb_img.' WHERE id='.$gal_id);
    $out_txt .= " Done.</p>";
    
    $out_txt .= "<p>Gallery Updated.</p>";
    
    $rep1   = $bdd->query('SELECT * FROM '.getTablePrefix().'galleries WHERE id='.$gal_id);
    $don1   = $rep1->fetch();
    $name   = $don1['name'];
    $author = $don1['author'];
    $nb_img = $don1['nb_img'];
    $_SESSION['script'] = "showEditGalleryImagesForm('$gal_id', '$name', '$author', '$nb_img');";
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
