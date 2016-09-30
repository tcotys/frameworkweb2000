<?php
  include_once('../../../includes/libraries_includer.inc.php');
  require_once('../handle_images.req.php');
  $_SESSION['anchored_page'] = 'galleries_article';
  
  $out_txt = "<h2>Ajout d\'un nouveau document</h2>";
  $error = 0;
  if(isset($_POST['gal_id'])) {
    $gal_id = intval($_POST['gal_id']);
    
//     echo "<pre>";
//     print_r($_FILES);
//     echo "</pre>";
//     $error = 1;

      // http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
      // $valid_formats = array("jpg", "png", "gif", "zip", "bmp");
      // $max_file_size = 1024*100; //100 kb
      // $path = "uploads/"; // Upload directory
      // $count = 0;
      // 
      // if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
      //   // Loop $_FILES to exeicute all files
      //   foreach ($_FILES['files']['name'] as $f => $name) {     
      //       if ($_FILES['files']['error'][$f] == 4) {
      //           continue; // Skip file if any error found
      //       }        
      //       if ($_FILES['files']['error'][$f] == 0) {            
      //           if ($_FILES['files']['size'][$f] > $max_file_size) {
      //               $message[] = "$name is too large!.";
      //               continue; // Skip large files
      //           }
      //       elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
      //         $message[] = "$name is not a valid format";
      //         continue; // Skip invalid file formats
      //       }
      //           else{ // No error found! Move uploaded files 
      //               if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name))
      //               $count++; // Number of successfully uploaded file
      //           }
      //       }
      //   }
      // }

    $req1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'galleries WHERE id=:gal_id');
    $req1->execute(array('gal_id'=>$gal_id));
    $don1 = $req1->fetch();
    $max_mini_width   = $don1['mini_width'];
    $max_mini_height  = $don1['mini_height'];
    $max_large_width  = $don1['large_width'];
    $max_large_height = $don1['large_height'];
    $nb_img           = $don1['nb_img'];
    $allowed_filetype = array('jpg', 'jpeg', 'png', 'gif');
    
    // ----- Upload du poster de la vidéo ----- //
    foreach ($_FILES['images']['name'] as $it1 => $name) {
      if ($_FILES['images']['error'][$it1] == 0) {
        $infosfichier = pathinfo($_FILES['images']['name'][$it1]);
        $filetype = strtolower($infosfichier['extension']);
        $out_txt .= "<p>New poster detected...</p>";
        
        $animated_gif = false;
        if($filetype == 'gif') {
          if(is_animated_gif($_FILES['images']['tmp_name'][$it1])) {
            $animated_gif = true;
          }
        }
        
        if (in_array($filetype, $allowed_filetype) && !$animated_gif)
        {
          $nb_img++;

          if($filetype == 'jpg' || $filetype == 'jpeg') {
            $image1 = imagecreatefromjpeg($_FILES['images']['tmp_name'][$it1]);
          }
          else if ($filetype == 'gif'){
            $image1 = imagecreatefromgif($_FILES['images']['tmp_name'][$it1]);
          }
          else if ($filetype == 'png'){
            $image1 = imagecreatefrompng($_FILES['images']['tmp_name'][$it1]);
          }
          $oldImageSize = getimagesize($_FILES['images']['tmp_name'][$it1]);
          $w1 = $oldImageSize[0];
          $h1 = $oldImageSize[1];
          
          // ----- Miniatures ----- //
          
          $w2 = $max_mini_width;
          $h2 = $max_mini_height;
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
          $poster_uploaded = 0;
          $poster_addr = "../../../../galleries/$gal_id/mini/$nb_img.$filetype";
          
          if(imagejpeg($image2 , $poster_addr, 100)){  
            $out_txt .= "<p>Mise en ligne du poster réussie !</p>";
          }
          else {
            $out_txt .= "<p>Waring: Mise en ligne du poster impossible</p>";
          }
                    
          // ----- Larges ----- //
          
          $w2 = $max_large_width;
          $h2 = $max_large_height;
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
          $poster_addr = "../../../../galleries/$gal_id/large/$nb_img.$filetype";
          
          if(imagejpeg($image2 , $poster_addr, 100)){  
            $out_txt .= "<p>Mise en ligne du poster réussie !</p>";
          }
          else {
            $out_txt .= "<p>Waring: Mise en ligne du poster impossible</p>";
          }
          
          // ----- Saving the orginals in a specific folder (if we want to resize images) ----- //
          if(move_uploaded_file($_FILES['images']['tmp_name'][$it1], "../../../../galleries/$gal_id/originals/$nb_img.$filetype")) {
            $out_txt .= "<p>Original image saved.</p>";
          }
          else {
            $out_txt .= "<p>Warning: Orginal not saved.</p>";
          }
          
        }
      }
    }
    $bdd->query('UPDATE '.getTablePrefix().'galleries SET nb_img='.$nb_img.' WHERE id='.$gal_id);
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
