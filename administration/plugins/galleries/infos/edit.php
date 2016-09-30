<?php
  include_once('../../../includes/libraries_includer.inc.php');
  require_once('../handle_images.req.php');
  $_SESSION['anchored_page'] = 'galleries_article';
  
  $out_txt = "<h2>Edition des info de gallerie</h2>";
  $error = 0;
  
  if(isset($_POST['gal_id']) && isset($_POST['name']) && isset($_POST['author']) && isset($_POST['mini_width']) && isset($_POST['mini_height']) && isset($_POST['large_width']) && isset($_POST['large_height'])) {
    $gal_id       = intval($_POST['gal_id']);
    $name         = setHtmlToMysql($_POST['name']);
    $author       = setHtmlToMysql($_POST['author']);
    $mini_width   = intval($_POST['mini_width']);
    $mini_height  = intval($_POST['mini_height']);
    $large_width  = intval($_POST['large_width']);
    $large_height = intval($_POST['large_height']);
    
    $req1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'galleries WHERE id=:gal_id');
    $req1->execute(array('gal_id'=>$gal_id));
    $don1 = $req1->fetch();
    $old_mini_width   = $don1['mini_width'];
    $old_mini_height  = $don1['mini_height'];
    $old_large_width  = $don1['large_width'];
    $old_large_height = $don1['large_height'];
    
    $out_txt .= "<p>Anciennes donnnées récupérées</p>";
    
    $req2 = $bdd->prepare('UPDATE '.getTablePrefix().'galleries
                    SET name         = :name,
                        author       = :author,
                        mini_width   = :mini_width,
                        mini_height  = :mini_height,
                        large_width  = :large_width,
                        large_height = :large_height
                  WHERE id           = :gal_id');
    $req2->execute(array('name'         =>  $name,
                         'author'       =>  $author,
                         'mini_width'   =>  $mini_width,
                         'mini_height'  =>  $mini_height,
                         'large_width'  =>  $large_width,
                         'large_height' =>  $large_height,
                         'gal_id'       =>  $gal_id));
    $out_txt .= "<p>Nouvelles infos mises à jour.</p>";
    
    if($old_mini_width != $mini_width || $old_mini_height != $mini_height) {
      $out_txt .= "<p>Gallery miniatures size changed... Changing images size.</p>";
      $out_txt .= "<p>Clearing old miniatures folder.</p>";
      $out_txt .= clearDir("../../../../galleries/$gal_id/mini/", false, true);
      $out_txt .= "<p>Copying new miniatures</p>";
      $out_txt .= copyAndResize("../../../../galleries/$gal_id/originals/", "../../../../galleries/$gal_id/mini/", $mini_width, $mini_height, true, false, false);
      $out_txt .= "<p>Done.</p>";
    }
    
    if($old_large_width != $large_width || $old_large_height != $large_height) {
      $out_txt .= "<p>Gallery miniatures size changed... Changing images size.</p>";
      $out_txt .= "<p>Clearing old miniatures folder.</p>";
      $out_txt .= clearDir("../../../galleries/$gal_id/large/", false, true);
      $out_txt .= "<p>Copying new miniatures</p>";
      $out_txt .= copyAndResize("../../../../galleries/$gal_id/originals/", "../../../../galleries/$gal_id/large/", $large_width, $large_height, true, false, false);
      $out_txt .= "<p>Done.</p>";
    }
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
