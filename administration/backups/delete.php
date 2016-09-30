<?php
  include_once('../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'backups_article';
  
  $out_txt = '<h2>Backup file delete</h2>';
  $error = 0;
  
  $root_dir = getcwd();
  $root_dir = explode('/',$root_dir );
  array_pop($root_dir);
  array_pop($root_dir);
  $root_dir = implode('/', $root_dir).'/';
  
  $backup_folder = "";
  
  $isset_backup_file = false;
  if(isset($_POST['file'])) {
    $backup_file = $_POST['file'];
    $isset_backup_file = true;
  }
  if($isset_backup_file) {
    $backup_zip_url = $backup_folder.$backup_file;
    if (unlink($backup_zip_url)) {
      $out_txt .= "<p>Backup file \"$backup_zip_url\" deleted.</p>";
    }
    else {
      $error = 1;
      $out_txt .= "<p>Error : Cannot delete backup file \"$backup_zip_url\".</p>";
    }
  }
  else {
    $out_txt .= "<p>No backup file selected.</p>";
    $error = 1;
  }
      
  if($error == 0) {
    $_SESSION['message'] = $out_txt;
    header("Location: ../index.php");
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
