<?php
  include_once('../../includes/libraries_includer.inc.php');
  require_once('handle_videos.req.php');
  $_SESSION['anchored_page'] = 'videos_article';
  
  $out_txt = "<h2>Edition d\'une vidéo</h2>";
  $error = 0;
  if(isset($_POST['vid_id'])) {
    $vid_id = intval($_POST['vid_id']);
    
    print_r($_POST);
    
    if(isset($_POST['vid_name']) && isset($_POST['vid_type']) && isset($_POST['vid_width']) && isset($_POST['vid_height']))
    {
      $vid_name      = htmlspecialchars($_POST['vid_name']);
      $vid_type      = htmlspecialchars($_POST['vid_type']);
      $poster_width  = intval($_POST['vid_width']);
      $poster_height = intval($_POST['vid_height']);
      
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'videos
                                SET name=:name,
                                    width=:width,
                                    height=:height,
                                    type=:type
                              WHERE id=:vid_id');
      $req->execute(array('name'=>$vid_name,
                          'width'=>$poster_width,
                          'height'=>$poster_height,
                          'type'=>$vid_type,
                          'vid_id'=>$vid_id));
      $out_txt .= "<p>Basic informations updated.</p>";
    }
    
    // ----- Upload du poster de la vidéo ----- //
    if(isset($_FILES['vid_poster']) && $_FILES['vid_poster']['error'] == 0 && isset($_POST['vid_width']) && isset($_POST['vid_height']))
    {
      $infosfichier = pathinfo($_FILES['vid_poster']['name']);
      $filetype = strtolower($infosfichier['extension']);
      $forbidden_filetype = array('jpg', 'jpeg', 'png', 'gif');
      $out_txt .= "<p>New poster detected...</p>";
      
      $animated_gif = false;
      if($filetype == 'gif') {
        if(is_animated_gif($_FILES['vid_poster']['tmp_name'])) {
          $animated_gif = true;
        }
      }
      
      if (in_array($filetype, $forbidden_filetype) && !$animated_gif)
      {
        $poster_width  = intval($_POST['vid_width']);
        $poster_height = intval($_POST['vid_height']);
    
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
        if(($w1*$h2)/($h1*$w2) > 1) { // redimentionnement sans déformation
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
        $poster_addr = "../../../videos/$vid_id.jpg";
        
        if(imagejpeg($image2 , $poster_addr, 100)){  
          $out_txt .= "<p>Mise en ligne du poster réussie !</p>";
        }
        else {
          $out_txt .= "<p>Waring: Mise en ligne du poster impossible</p>";
        }
      }
    }
    
    
    
    if(isset($_POST['vid_width']) && isset($_POST['vid_height']))
    {
      $poster_width  = intval($_POST['vid_width']);
      $poster_height = intval($_POST['vid_height']);
      $poster_addr = "../../../videos/$vid_id.jpg";
      $oldImageSize = getimagesize($poster_addr);
      $w1 = $oldImageSize[0];
      $h1 = $oldImageSize[1];
      $w2 = $poster_width;
      $h2 = $poster_height;
      
      if(!(($w1==$w2 or $h1==$h2) and ($w1<=$w2 and $h1<=$h2))) {
        $out_txt .= "<p>Resizing poster...";
        $image1 = imagecreatefromjpeg($poster_addr);
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
        
        if(imagejpeg($image2 , $poster_addr, 100)){  
          $out_txt .= "Done.</p>";
        }
        else {
          $error = 1;
          $out_txt .= "</p><p>Error: Cannot resize poster.</p>";
        }
      }
    }
    
    
    if ($vid_type == "youtube" && isset($_POST['youtube_url'])) {
      $youtube_url   = htmlspecialchars($_POST['youtube_url']);
      $out_txt .= "<p>Youtube video detected</p>";
      if($youtube_url != "Url de la video") {
        $req = $bdd->prepare('UPDATE '.getTablePrefix().'videos SET type=:type, source=:source  WHERE id=:vid_id');
        $req->execute(array('type'=>$vid_type, 'source'=>$youtube_url, 'vid_id'=>$vid_id));
      }
    }
    
    if ($vid_type == "local") {
      $out_txt .= "<p>Local video detected</p>";
      $has_vid_source = 0;
      $vid_ext_list = array('mp4', 'webm', 'ogv');
      $vid_source_local = array();
      foreach ($vid_ext_list as $vid_ext) {
        if(isset($_FILES['vid_source'.strtoupper($vid_ext)]) && $_FILES['vid_source'.strtoupper($vid_ext)]['error'] == 0) {
          $out_txt .= "<p>$vid_ext file detected : Checking filetype... ";
          $info_vid1 = pathinfo($_FILES['vid_source'.strtoupper($vid_ext)]['name']);
          $filetype1 = strtolower($info_vid1['extension']);
          if($filetype1 == $vid_ext) {
            $out_txt .= "$vid_ext filetype checked.</p>";
            $has_vid_source = 1;
            array_push($vid_source_local, 'mp4');
            if(move_uploaded_file($_FILES['vid_source'.strtoupper($vid_ext)]['tmp_name'], "../../../videos/$vid_id.$vid_ext")) {
              $out_txt .= "<p>Video (type: $vid_ext) uploaded.</p>";
            }
            else {
              $out_txt .= "<p>Warning: Cannot upload video (format: $vid_ext).</p>";
            }
          }
          else {
            $out_txt .= "Error.</p><p>Warning : Wrong $vid_ext filetype, it will not be updated.</p>"; 
          }
        }
      }
      if ($has_vid_source == 1) {  
        $vid_source = implode('.', $vid_source_local);
        $req = $bdd->prepare('UPDATE '.getTablePrefix().'videos SET source=:source WHERE id=:vid_id');
        $req->execute(array('source'=>$vid_source,'vid_id'=>$vid_id));
      }
      else {
//        $error = 1;
        $out_txt .= "<p>Warning: No file detected for upload.</p>";
      }
    }
  }
  else {
    $error = 1;
    $out_txt .= "<p>Error: Wrong input parameters.</p>";
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
