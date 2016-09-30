<?php
  include_once('../../includes/libraries_includer.inc.php');
  require_once('handle_videos.req.php');
  $_SESSION['anchored_page'] = 'videos_article';
  
  $out_txt = "<h2>Ajout d\'une nouvelle vidéo</h2>";
  $error = 0;
  
  if(isset($_POST['vid_name']) && isset($_FILES['vid_poster']) && $_FILES['vid_poster']['error'] == 0)
  {
    $vid_name      = htmlspecialchars($_POST['vid_name']);
    $poster_name   = htmlspecialchars($_FILES['vid_poster']['name']);
    $vid_type      = htmlspecialchars($_POST['vid_type']);
    $youtube_url   = htmlspecialchars($_POST['youtube_url']);
    $poster_width  = intval($_POST['vid_width']);
    $poster_height = intval($_POST['vid_height']);
    $out_txt .= "<p>Tentative de mise en ligne du document : ".$vid_name."...</p>";
    
    $infosfichier = pathinfo($_FILES['vid_poster']['name']);
    $filetype = strtolower($infosfichier['extension']);
    $allowed_filetype = array('jpg', 'jpeg', 'png', 'gif'); 
    
    $animated_gif = false;
    if($filetype == 'gif') {
      if(is_animated_gif($_FILES['vid_poster']['tmp_name'])) {
        $animated_gif = true;
      }
    }
      
    if (in_array($filetype, $allowed_filetype) && !$animated_gif)
    {
      $has_vid_source = 0;
      if ($vid_type == "youtube" && $youtube_url != "Url de la video") {
        $vid_source = $youtube_url;
        $out_txt .= "<p>Vidéo youtube détectée</p>";
        $has_vid_source = 1;
      }
      elseif ($vid_type = 'local') {
        $vid_source_local = array();
        if(isset($_FILES['vid_sourceMP4']) && $_FILES['vid_sourceMP4']['error'] == 0) {
          $out_txt .= "<p>MP4 file detected : Checking filetype... ";
          $info_vid1 = pathinfo($_FILES['vid_sourceMP4']['name']);
          $filetype1 = strtolower($info_vid1['extension']);
          if($filetype1 == 'mp4') {
            $out_txt .= "MP4 filetype checked.</p>";
            $has_vid_source = 1;
            array_push($vid_source_local, 'mp4');
          }
          else {
            $out_txt .= "Error.</p><p>Warning : Wrong Mp4 filetype, it will not be updated.</p>"; 
          }
        }
        if(isset($_FILES['vid_sourceWEBM']) && $_FILES['vid_sourceWEBM']['error'] == 0) {
          $out_txt .= "<p>WEBM file detected : Checking filetype... ";
          $info_vid2 = pathinfo($_FILES['vid_sourceWEBM']['name']);
          $filetype2 = strtolower($info_vid2['extension']);
          if($filetype2 == 'webm') {
            $out_txt .= "WEBM filetype checked.</p>";
            $has_vid_source = 1;
            array_push($vid_source_local, 'webm');
          }
          else {
            $out_txt .= "Error.</p><p>Warning : Wrong WEBM filetype, it will not be updated.</p>"; 
          }
        }
        if(isset($_FILES['vid_sourceOGV']) && $_FILES['vid_sourceOGV']['error'] == 0) {
          $out_txt .= "<p>OGV file detected : Checking filetype...  ";
          $info_vid3 = pathinfo($_FILES['vid_sourceOGV']['name']);
          $filetype3 = strtolower($info_vid3['extension']);
          if($filetype3 == 'ogv') {
            $out_txt .= "OGV filetype checked.</p>";
            $has_vid_source = 1;
            array_push($vid_source_local ,'ogv');
          }
          else {
            $out_txt .= "Error.</p><p>Warning : Wrong OGV filetype, it will not be updated.</p>"; 
          }
        }
        $vid_source = implode('.', $vid_source_local);
      }
      if ($has_vid_source == 1) {  
        try {
          $req1 = $bdd->prepare('INSERT INTO '.getTablePrefix().'videos(name, width, height, type, source)
                              VALUES(:new_name, :width, :height, :vid_type, :vid_source)');
          $req1->execute(array('new_name' => $vid_name, 'width' => $poster_width, 'height' => $poster_height, 'vid_type' => $vid_type, 'vid_source' => $vid_source));
        }
        catch (Exception $e) {
          $error = 1;
          $out_txt .= $e->getMessage().'<br />';
        }
        $out_txt .= "<p>Enregistrement du document dans la base de données</p>";
        $out_txt .= "<p>Préparation de la sauvegarde du document</p>";
        try {
          $rep2 = $bdd->query('SELECT MAX(id) AS vid_id FROM '.getTablePrefix().'videos');
          $don2 = $rep2->fetch();
        }
        catch (Exception $e) {
          $error = 1;
          $out_txt .= $e->getMessage().'<br />';
        }
        $vid_id = $don2['vid_id'];
        
        // ----- Upload des vidéeos sur le serveur, si c'est une vidéo locale ----- //
        if($vid_type == "local") {
          foreach($vid_source_local as $vid_type) {
            if(move_uploaded_file($_FILES['vid_source'.strtoupper($vid_type)]['tmp_name'], "../../../videos/$vid_id.$vid_type")) {
              $out_txt .= "<p>Video (type: $vid_type) uploaded.</p>";
            }
            else {
              $out_txt .= "<p>Warning: Cannot upload video (format: $vid_type).</p>";
            }
          }
        }
        
        // ----- Upload du poster au bone endroit ----- //
        $poster_addr = "../../../videos/$vid_id.$filetype";
        if($filetype == 'jpg' || $filetype == 'jpeg') {
          $image1 = imagecreatefromjpeg($_FILES['vid_poster']['tmp_name']);
        }
        else if ($filetype == 'gif'){
          $image1 = imagecreatefromgif($_FILES['vid_poster']['tmp_name']);
        }
        else if ($filetype == 'png'){
          $image1 = imagecreatefromgif($_FILES['vid_poster']['tmp_name']);
        }
        $oldImageSize = getimagesize($_FILES['vid_poster']['tmp_name']);
        $w1 = $oldImageSize[0];
        $h1 = $oldImageSize[1];
        $w2 = $poster_width;
        $h2 = $poster_height;
        if(($w1*$h2)/($h1*$w2) > 1) { // redinmentionnement sans déformation
          $w3 = $w2;
          $h3 = $w2*$h1/$w1;
        }
        else {
          $w3 = $h2*$w1/$h1;
          $h3 = $h2;
        }
        $image2 = imagecreatetruecolor($w3 , $h3);
        imagecopyresampled($image2 , $image1, 0, 0, 0, 0, $w3, $h3, $w1, $h1);
        imagedestroy($image1);
        $poster_uploaded = 0;
//         if($filetype == 'jpg' || $filetype == 'jpeg') {
        // ----- Poster toujours en jpg, afin de simplifier la base de données
        $poster_addr = "../../../videos/$vid_id.jpg";
          if(imagejpeg($image2 , $poster_addr, 100)) {$poster_uploaded = 1;}
//         }
//         else if ($filetype == 'gif'){
//           if(imagegif($image2 , $poster_addr, 100)) {$poster_uploaded = 1;}
//         }
//         else if ($filetype == 'png'){
//           if (imagepng($image2 , $poster_addr, 100)) {$poster_uploaded = 1;}
//         }
        
        if($poster_uploaded == 1){  
          $out_txt .= "<p>Mise en ligne du document réussie !</p>";
        }
        else {
          $error = 1;
          $out_txt .= "<p>Echec de la mise en ligne... retrait de l'image de la base de données.</p>";
          try {
            $req4 = $bdd->prepare('DELETE FROM '.getTablePrefix().'videos WHERE id=:old_id');
            $req4->execute(array( 'old_id' => $vid_id));
          }
          catch (Exception $e) {
            $error = 1;
            $out_txt .= $e->getMessage().'<br />';
          }
          $out_txt .= "<p>Retrait de la base de donnée réussie</p>";
        }
      }
      else {
        $error = 1;
        $out_txt .= "<p>Error: No video detected.</p>";
      }
    }
    else {
      $error = 1;
      $out_txt .= "<p>Erreur : Type de fichier de l'image non autorisé.</p>";
    }
  }
  else
  {
    $error = 1;
    switch ($_FILES['vid_poster']['error']) {
      case 1:
          $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
          break;
      case 2:
          $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
          break;
      case 3:
          $message = "The uploaded file was only partially uploaded";
          break;
      case 4:
          $message = "No file was uploaded";
          break;
      case 5:
          $message = "Missing a temporary folder";
          break;
      case 6:
          $message = "Failed to write file to disk";
          break;
      case 7:
          $message = "File upload stopped by extension";
          break;

      default:
          $message = "Unknown upload error";
          break;
    } 
    $out_txt .= "<p>Error : ".$message."</p>";
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
