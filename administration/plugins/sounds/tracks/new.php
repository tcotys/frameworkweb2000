<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'sounds_tracks_article';
  
  $out_txt = "<h2>Ajout de nouvelles pistes audio</h2>";
  $error = 0;
    
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

  $allowed_filetype = array('mp3', 'mp4', 'ogg', 'opus', 'wav');
  
  // ----- Upload du poster de la vidéo ----- //
  foreach ($_FILES['tracks']['name'] as $it1 => $name) {
    if ($_FILES['tracks']['error'][$it1] == 0) {
      $infosfichier = pathinfo($_FILES['tracks']['name'][$it1]);
      $filetype = strtolower($infosfichier['extension']);
      $out_txt .= "<p>New track detected...</p>";
      
      if (in_array($filetype, $allowed_filetype) && !$animated_gif)  {
        if($filetype == 'mp3' && function_exists('id3_get_tag')) {
          $track_id3    = id3_get_tag($_FILES['tracks']['tmp_name'][$it1]);
          $track_name   = $track_id3['title'];
          $track_author = $track_id3['artist']; 
        }
        else {
          $track_name   = addslashes($name);
          $track_author = "";
        }
        $req = $bdd->prepare('INSERT INTO '.getTablePrefix().'sounds_tracks(name, author, type, source, cover_type)
                              VALUES(:track_name, :track_author, "local", :filetype, "none")');
        if($req->execute(array('track_name'=>$track_name,'track_author'=>$track_author, 'filetype'=>$filetype))) {
          $out_txt .= "<p>Track saved in database.</p>";
          $rep1 = $bdd->query('SELECT MAX(id) as track_id FROM '.getTablePrefix().'sounds_tracks');
          $don1 = $rep1->fetch();
          $track_id = $don1['track_id'];
          $rep1->closeCursor();
          

          // ----- Saving the orginals in a specific folder (if we want to resize images) ----- //
          if(move_uploaded_file($_FILES['tracks']['tmp_name'][$it1], "../../../../sounds/$track_id.$filetype")) {
            $out_txt .= "<p>Track uploaded.</p>";
          }
          else {
            $out_txt .= "<p>Warning: Orginal not saved.</p>";
          }
        }
        else {
          $out_txt .= "<p>Error: Cannot update database.</p>";
        }
      }
      else {
        $out_txt .= "<p>Error: Wrong filetype.</p>";
      }
    }
    else {
      
      $out_txt .= "<p>Error: upload error #".$_FILES['tracks']['error'][$it1].":</p>";
      switch ($_FILES['tracks']['error'][$it1]) {
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
