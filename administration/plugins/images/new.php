<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'images_article';
  
  $out_txt = "<h2>Ajout d'une nouvelle image</h2>";
  $error = 0;
  if(isset($_POST['img_name']) && isset($_POST['out_folder']) && isset($_POST['out_filename']) && isset($_POST['img_type'])  && isset($_FILES['image_source']) && $_FILES['image_source']['error'] == 0)
  {
    $img_name = $_POST['img_name'];
    if(isset($_POST['is_in_images'])) {
      $is_in_images = true;
    }
    else {
      $is_in_images = false;
    }

    if($_POST['out_folder'] == "")  {
      $out_folder = "images/normal";
    }
    else {
      if(preg_match("#^[a-zA-Z0-9_]*$#", $_POST['out_folder']))  {
        if ($is_in_images) {
          $out_folder = 'images/'.$_POST['out_folder'];
        }
        else {
          $out_folder = $_POST['out_folder'];
        }
      }
      else {
        $out_folder = 'invalid_folder';
      }
    }
  
    if(preg_match("#^[a-zA-Z0-9_]*$#", $_POST['out_filename'])) {
      $out_filename = $_POST['out_filename'];
    }
    else{
      $out_filename = 'invalid_filename';
    }
    
    $img_type = $_POST['img_type'];
    $infosfichier = pathinfo($_FILES['image_source']['name']);
    $extension_upload = strtolower($infosfichier['extension']);
    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'tiff', 'mp3');
  
    if (in_array($extension_upload, $extensions_autorisees) && $out_filename != 'invalid_filename' && $out_folder != 'invalid_folder')
    {
      try {
        $req1 = $bdd->prepare('INSERT INTO '.getTablePrefix().'img(name, type, url) VALUES(:new_name, :new_type, "")');
        $req1->execute(array('new_name' => $img_name, 'new_type' => $img_type));
      }
      catch (Exception $e) {
        $error = 1;
        $out_txt .= $e->getMessage().'<br />';
      }
//      $out_txt .= "<p>Enregistrement de l'image dans la base de données</p>";
//      $out_txt .= "<p>Préparation de la sauvegarde de l'image</p>";
      try {
        $rep_id_img = $bdd->query('SELECT MAX(id) AS id_img FROM '.getTablePrefix().'img');
        $don_id_img = $rep_id_img->fetch();
      }
      catch (Exception $e) {
        $error = 1;
        $out_txt .= $e->getMessage().'<br />';
      }
      $id_img = $don_id_img['id_img'];
      if($out_filename == "") {
        $out_filename = $id_img.'.'.$extension_upload;}
      else {
        $out_filename = $out_filename.'.'.$extension_upload;}
      
      if(!is_dir('../../../'.$out_folder)){
        $out_txt .= "<p>Le dossier de destinatsion ".$out_folder." n'existait pas.</p>";
        if(mkdir('../../../'.$out_folder, 0777)){
          $out_txt .= "<p>Celui-ci a été créé.</p>";}
        else {
          $out_txt .= "<p>Impossible de le créer.</p>";}
      }
      $destination = $out_folder.'/'.$out_filename;
      
      if(move_uploaded_file($_FILES['image_source']['tmp_name'], '../../../'.$destination))
      {
        $out_txt .= "<p>Mise en ligne de l'image réussie !</p>";
        try {
          $req2 = $bdd->prepare('UPDATE '.getTablePrefix().'img SET url=:new_url WHERE id=:old_id');
          $req2->execute(array('new_url' => $destination, 'old_id' => $id_img));
        }
        catch (Exception $e) {
          $error = 1;
          $out_txt .= $e->getMessage().'<br />';
        }
      }
      else
      {
        $out_txt .= "<p>Echec de la mise en ligne... retrait de l'image de la base de données.</p>";
        try {
          $req3 = $bdd->prepare('DELETE FROM '.getTablePrefix().'img WHERE id=:old_id');
          $req3->execute(array( 'old_id' => $id_img));
        }
        catch (Exception $e) {
          $error = 1;
          $out_txt .= $e->getMessage().'<br />';
        }
        $out_txt .= "<p>Retrait de la base de donnée réussie</p>";
      }
    }
    else
    {
      $out_txt .= "<p>Erreur dans le nom du fichier, ou du dossier de destination.</p>";
    }
  }
  else
  {
    $out_txt .= "<p>Erreur... </p>";
            switch ($_FILES['image_source']['error']) {
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
    $out_txt .= "<p>".$message."</p>";
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
