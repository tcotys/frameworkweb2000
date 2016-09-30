<?php
  include_once('../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'backups_article';
  
  $out_txt = "<h2>Ajout d\'un fichier de backup</h2>";
  $error = 0;
  
  if(isset($_FILES['file_source'])) {
    if ($_FILES['file_source']['error'] == 0) {
      $tmp_url = $_FILES['file_source']['tmp_name'];
      $tmp_name = $_FILES['file_source']['name'];
      $tmp_type = $_FILES['file_source']['type'];
      $out_txt .= "<p>Filetype : $tmp_type</p>";
      if($tmp_type == 'application/zip') {
        $out_txt .= "<p>Opening file...</p>";
        $zip_file = new ZipArchive;
        if ($zip_file->open($tmp_url, ZipArchive::CREATE) === TRUE) {
          $out_txt .= "<p>Checking filecontent</p>";
          $has_images_folder = false;
          $has_files_folder = false;
          $has_sql_db_file = false;
          for ($it1 = 0; $it1 < $zip_file->numFiles; $it1++) {
            $entry = $zip_file->getNameIndex($it1);
            if(preg_match('#^images/$#', $entry)) {
              $has_images_folder = true;
              $out_txt .= "<p>Images folder found.</p>";
            }
            if(preg_match('#^files/$#', $entry)) {
              $has_files_folder = true;
              $out_txt .= "<p>Files folder found.</p>";
            }
            if(preg_match('#^sql_db.asc$#', $entry)) {
              $has_sql_db_file = true;
              $out_txt .= "<p>SQL content file found.</p>";
            }
          }
          if($has_files_folder and $has_images_folder and $has_sql_db_file) {
            $admin_dir = getcwd();
            $backup_dir_url = $admin_dir.'/backups/';
            $out_txt .= "<p>Moving uploaded file from \"$tmp_url\" to \"$backup_dir_url.$tmp_name\"... "; 
            if(move_uploaded_file($tmp_url, $backup_dir_url.$tmp_name)) {
              $out_txt .= "Backup file uploaded.</p>";
            }
            else {
              $error = 1;
              $out_txt .= "</p><p>Error: Cannot move backup file to the backup directory.</p>";
            }
          }
          else {
            $error = 1;
            $out_txt .= "<p>Error: Backup file doesn't contain basic info.</p>";
          }
        }
        else {
          $error = 1;
          $out_txt .= "<p>Error: Cannot open backup file.</p>";
        }
      }
      else {
        $error = 1;
        $out_txt .= "<p>Error: Wrong filetype.</p>";
      }
    }
    else {
      $error = 1;
      switch ($_FILES['file_source']['error']) {
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
      $out_txt .= "<p>Error: $message </p>";
    }
  }
  else {
    $error = 1;
    $out_txt .= "<p>Error: No backup file selected.</p>";
  }
  
  if ($error == 0) {
    $_SESSION['message'] = $out_txt;
    header('Location: ../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
