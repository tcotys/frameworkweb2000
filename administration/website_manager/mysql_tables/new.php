<?php
  include_once('../../includes/libraries_includer.inc.php');
  require_once('../install.req.php');
  $_SESSION['anchored_page'] = 'website_manager_article';
  $out_txt = "";
  $error = 0;

  $out_txt = "<h2>Ajout d\'un nouveau plugin</h2>";
  $error = 0;
  
  if(isset($_FILES['file_source']) && $_FILES['file_source']['error'] == 0)
  {
    $filename = htmlspecialchars($_FILES['file_source']['name']);
    $out_txt .= "<p>Tentative de mise en ligne du document : ".$surname."(".$filename.")...</p>";
    
    $infosfichier = pathinfo($_FILES['file_source']['name']);
    $filetype = strtolower($infosfichier['extension']);

    if ($filetype == "zip")
    {
      $debug = true;
      $zip_path = $_FILES['file_source']['tmp_name'];
      $out_txt .= function extractPluginFiles($zip_path, $debug) {

    }
    else
    {
      $error = 1;
      $out_txt .= "<p>Error : Wrong filetype.</p>";
    }
  }
  else
  {
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