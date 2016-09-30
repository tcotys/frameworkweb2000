<?php
  include_once('../../../includes/libraries_includer.inc.php');
  require_once('../handle_images.req.php');
  $_SESSION['anchored_page'] = 'galleries_article';

  $out_txt = "<h2>Edition des images de gallerie</h2>";
  $error = 0;
  if(isset($_POST['gal_id']) && isset($_POST['new_id']) && isset($_POST['old_id']) && isset($_POST['nb_img'])) {
    $gal_id       = intval($_POST['gal_id']);
    $old_id       = intval($_POST['old_id']);
    if($_POST['new_id'] == "end") {$new_id = "end";}
    else {$new_id = intval($_POST['new_id']);}
    $nb_img       = intval($_POST['nb_img']);
    
    $rep1   = $bdd->query('SELECT * FROM '.getTablePrefix().'galleries WHERE id='.$gal_id);
    $don1   = $rep1->fetch();
    $name   = $don1['name'];
    $author = $don1['author'];
    
//     $error = 1;
//     echo '<pre>';
//     print_r($_POST);
//     echo '</pre>';
    
    if($new_id == "end") {
      $new_id = $nb_img+1;
      
      $out_txt .= "<p>Moving miniatures...</p>";
      $ini_dir  = "../../../../galleries/$gal_id/mini/";
      $tmp_dir  = "../../../../galleries/$gal_id/mini_tmp/";
      $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
      copy($ini_dir.$old_id.".jpg", $tmp_dir.$new_id.".jpg");
      $out_txt .= clearDir($ini_dir, true, false);
      $out_txt .= copyWithoutAnImage($tmp_dir, $ini_dir, $old_id, true, false);
      $out_txt .= deleteDir($tmp_dir, false);
      $out_txt .= "<p>Done.</p>";
      
      $out_txt .= "<p>Moving large images...</p>";
      $ini_dir  = "../../../../galleries/$gal_id/large/";
      $tmp_dir  = "../../../../galleries/$gal_id/large_tmp/";
      $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
      copy($ini_dir.$old_id.".jpg", $tmp_dir.$new_id.".jpg");
      $out_txt .= clearDir($ini_dir, true, false);
      $out_txt .= copyWithoutAnImage($tmp_dir, $ini_dir, $old_id, true, false);
      $out_txt .= deleteDir($tmp_dir, false);
      $out_txt .= "<p>Done.</p>";
      
      $out_txt .= "<p>Moving originals...</p>";
      $ini_dir  = "../../../../galleries/$gal_id/originals/";
      $tmp_dir  = "../../../../galleries/$gal_id/originals_tmp/";
      $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
          if(file_exists($ini_dir.$old_id.".jpg")) {copy($ini_dir.$old_id.".jpg", $tmp_dir.$new_id.".jpg");}
      elseif(file_exists($ini_dir.$old_id.".png")) {copy($ini_dir.$old_id.".png", $tmp_dir.$new_id.".png");}
      elseif(file_exists($ini_dir.$old_id.".gif")) {copy($ini_dir.$old_id.".gif", $tmp_dir.$new_id.".gif");}
      $out_txt .= clearDir($ini_dir, true, false);
      $out_txt .= copyWithoutAnImage($tmp_dir, $ini_dir, $old_id, true, false);
      $out_txt .= deleteDir($tmp_dir, false);
      $out_txt .= "<p>Done.</p>";
    }
    else {
      $out_txt .= "<p>Moving miniatures...</p>";
      $ini_dir  = "../../../../galleries/$gal_id/mini/";
      $tmp_dir  = "../../../../galleries/$gal_id/mini_tmp/";
      $out_txt .= "<p>Moving image in tmp folder.</p>";
      $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
      $out_txt .= clearDir($ini_dir, true, false);
      $out_txt .= copyMoveImage($tmp_dir, $ini_dir, $old_id, $new_id, true, false);
      $out_txt .= deleteDir($tmp_dir, false);
      $out_txt .= "<p>Done.</p>";
      
      $out_txt .= "<p>Moving large images...</p>";
      $ini_dir  = "../../../../galleries/$gal_id/large/";
      $tmp_dir  = "../../../../galleries/$gal_id/large_tmp/";
      $out_txt .= "<p>Moving image in tmp folder.</p>";
      $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
      $out_txt .= clearDir($ini_dir, true, false);
      $out_txt .= copyMoveImage($tmp_dir, $ini_dir, $old_id, $new_id, true, false);
      $out_txt .= deleteDir($tmp_dir, false);
      $out_txt .= "<p>Done.</p>";
      
      $out_txt .= "<p>Moving originals...</p>";
      $ini_dir  = "../../../../galleries/$gal_id/originals/";
      $tmp_dir  = "../../../../galleries/$gal_id/originals_tmp/";
      $out_txt .= "<p>Moving image in tmp folder.</p>";
      $out_txt .= copyDirectoryFiles($ini_dir, $tmp_dir);
      $out_txt .= clearDir($ini_dir, true, false);
      $out_txt .= copyMoveImage($tmp_dir, $ini_dir, $old_id, $new_id, true, false);
      $out_txt .= deleteDir($tmp_dir, false);
      $out_txt .= "<p>Done.</p>";
    }
    $out_txt .= "<p>Gallery Updated.</p>";
    
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
