<?php
  include_once('../../../includes/libraries_includer.inc.php');
  require_once('../handle_images.req.php');
  $_SESSION['anchored_page'] = 'galleries_article';

  $out_txt = "<h2>Enregistrement d\'une nouvelle gallerie</h2>";
  $error = 0;
  if(isset($_POST['name']) && isset($_POST['author']) && isset($_POST['mini_width']) && isset($_POST['mini_height']) && isset($_POST['large_width']) && isset($_POST['large_height'])) {
    $name         = setHtmlToMysql($_POST['name']);
    $author       = setHtmlToMysql($_POST['author']);
    $mini_width   = intval($_POST['mini_width']);
    $mini_height  = intval($_POST['mini_height']);
    $large_width  = intval($_POST['large_width']);
    $large_height = intval($_POST['large_height']);
    $req0 = $bdd->prepare('INSERT INTO '.getTablePrefix().'galleries(name, author, mini_width, mini_height, large_width, large_height, nb_img) 
                    VALUES(:name, :author, :mini_width, :mini_height, :large_width, :large_height, 0 )');
    if($req0->execute(array('name'=>$name, 'author'=>$author, 'mini_width'=>$mini_width, 'mini_height'=>$mini_height, 'large_width'=>$large_width, 'large_height'=>$large_height))) {
      $out_txt .= "<p>Enregistrement réussit !</p>";
      $out_txt .= "<p>Création des dossiers associés à la gallerie.</p>";
      
      $rep1 = $bdd->query('SELECT MAX(id) AS gal_id FROM '.getTablePrefix().'galleries');
      $don1 = $rep1->fetch();
      $gal_id = $don1['gal_id'];
      if(mkdir('../../../../galleries/'.$gal_id, 0777)) {
        if(mkdir('../../../../galleries/'.$gal_id.'/mini/', 0777) && mkdir('../../../../galleries/'.$gal_id.'/large/', 0777) && mkdir('../../../../galleries/'.$gal_id.'/originals/', 0777)) {
          $out_txt .= "<p>Dossiers associés à la gallerie créés.</p>";
        }
        else {
          $error = 1;
          $out_txt .= "<p>Error: Cannot create subfoders.</p>";
        }
      }
      else {
        $out_txt .= "<p>Error: Cannot create main folder.</p>";
      }
        
      
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
