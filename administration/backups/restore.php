<?php
  include_once('../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'backups_article';
  
  $out_txt = '<h2>Loading backup file</h2>';
  $error = 0;
  
  $root_dir = getcwd();
  $root_dir = explode('/',$root_dir );
  array_pop($root_dir);
  $root_dir = implode('/', $root_dir).'/';
//   $backup_id = 'backup_de_tyrasonore_20140827-15.26.02/';
//   $backup_dir = $root_dir.'administration/backups/'.$backup_id;
  $backup_folder = $root_dir.'administration/backups/';
//   $backup_file = 'backup20140827_174531.zip';
  $isset_backup_file = false;
  if(isset($_GET['file'])) {
    $backup_file = $_GET['file'];
    $isset_backup_file = true;
  }
  if($isset_backup_file) {
    $backup_zip_url = $backup_folder.$backup_file;
    $zip_file = new ZipArchive;
    if($zip_file->open($backup_zip_url, ZipArchive::CREATE) === TRUE) {
      $out_txt .= "<p>Backup ZIP file read.</p>";
    
      $out_txt .= "<p>Starting images and files recovery...</p>";
      $out_txt .= copyZipToDirectory($zip_file, $root_dir, 'images/');
      $out_txt .= copyZipToDirectory($zip_file, $root_dir, 'files/');
      
    //   $out_txt .= copyDirectoryFiles($backup_dir, $root_dir, 'images/');
    //   $out_txt .= copyDirectoryFiles($backup_dir, $root_dir, 'files/');
      $out_txt .= "<p>Images and files recovery done.</p>";
      
      $out_txt .= "<p>Starting database recovery...</p>";
    //   $sql_backup_url = $backup_dir.'sql_db.asc';
      try {
        $sql_backup_out = $zip_file->getFromName('sql_db.asc');
        
    //     $sql_backup_file = fopen($sql_backup_url, 'r');
    //     $sql_backup_out = fread($sql_backup_file, filesize($sql_backup_url));
    //     fclose($sql_backup_file);

        $sql_backup_out = preg_replace('#\[SQL_TABLE_PREFIX\]#', getTablePrefix(), $sql_backup_out);
      }
      catch (Exception $e) {
        print_r($e->getMessage());
        $error = 1;
      }
      try {
        $bdd->query($sql_backup_out) or die(print_r($bdd->errorInfo()));
      }
      catch (Exception $e) {
        print_r($e->getMessage());
        $error = 1;
      }
      $out_txt .= "<p>Database recovered.</p>";
    }
    else {
      $out_txt .= "<p>Error: Cannot read the backup ZIP file.</p>";
    }
  }
  else {
    $out_txt .= "<p>Error: No backup file selected.</p>";
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
