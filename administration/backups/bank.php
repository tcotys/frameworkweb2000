<?php
  include_once('../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'backups_article';
  
  $out_txt = '<h2>Creating backup file</h2>';
  $error = 0;
  $sql_backup_out = '';
  
  
  // ----- initialisation des plugins ----- //
  $PluginsInfo = array();
  
  include '../local_pages/config.php';
  include '../global_pages/config.php';
  $plugin_dir = '../plugins/';
  if ($handle = opendir($plugin_dir)) {
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        if(is_file($plugin_dir.$entry.'/config.php')) {
          include $plugin_dir.$entry.'/config.php';
        }
      }
    }
    closedir($handle); 
  }
  else {
    $out_txt .= "<p>Error: Cannot read directory.</p>";
  }
  include '../backups/config.php';
  $setValues = array('text', 'texts', 'file', 'files');
  
  // ----- Set the root folder ----- //
  $root_dir = getcwd();
  $root_dir = explode('/',$root_dir );
  array_pop($root_dir);
  array_pop($root_dir);
  $root_dir = implode('/', $root_dir).'/';

//   $backup_zip_url =  $root_dir.'administration/backups/backup'.date('Ymd_His').'.zip';
  $backup_zip_url =  'backup'.date('Ymd_His').'.zip';
  $zip_file = new ZipArchive;
  if($zip_file->open($backup_zip_url, ZipArchive::CREATE) === TRUE) {
    $out_txt .= "<p>Backup ZIP file created !</p>";

    $out_txt .= "<p>Starting database backup...</p>";
//     foreach($table_list as $table_name => $table_create_script) {
    foreach($PluginsInfo as $plugin) {
      if(in_array($plugin['db_name_type'], $setValues) && in_array($plugin['db_create_type'], $setValues)) {
        if($plugin['db_name_type'] == 'text') {// pour le moment, seul le format text est supporté...
          $table_name = $plugin['db_name'];
        }
        elseif($plugin['db_name_type'] == 'file') {
          include $plugin['db_name'];
        }
        if($plugin['db_create_type'] == 'text') {
          $table_create_script = $plugin['db_create'];
        }
        elseif($plugin['db_create_type'] == 'file') {
          include $plugin['db_create'];
        }
        try {
          $out_txt .= "<p>Reading table :".$table_name."... ";
          $rep1 = $bdd->query('SELECT * FROM '.getTablePrefix().$table_name.' ORDER BY id');
          $out_txt .= "Table reached. ";
        }
        catch (Exception $e) {
          $error = 1;
          $out_txt .= "</p><p>Error : Cannot reach table.</p>";
          print_r($e->getMessage());
        }
        $out_txt .= "Values... ";
        $sql_backup_out .= "-- --------------------------------------------------------\n";
        $sql_backup_out .= "-- Structure de la table [SQL_TABLE_PREFIX]$table_name\n";
        $sql_backup_out .= "-- --------------------------------------------------------\n";
        $sql_backup_out .= "  CREATE TABLE IF NOT EXISTS [SQL_TABLE_PREFIX]$table_name (\n";
        $sql_backup_out .= $table_create_script;
        $sql_backup_out .= "-- --------------------------------------------------------\n";
        $sql_backup_out .= "-- Initialisation de la table [SQL_TABLE_PREFIX]$table_name\n\n";
        $sql_backup_out .= "TRUNCATE [SQL_TABLE_PREFIX]".$table_name.";\n\n";
        $sql_backup_out .= "-- --------------------------------------------------------\n";
        $sql_backup_out .= "-- Données de la table [SQL_TABLE_PREFIX]$table_name\n\n";
        
        $it3 = 0;
        $id_max = 0;
        while ($don1 = $rep1->fetch()) {
          $table_keys   = array_keys($don1); // it pair => text, it impair: numeros
          $table_values = array_values($don1);
          $table_length = count($table_keys);
          
          if($don1['id'] > $id_max) {
            $id_max = $don1['id'];
          }
          
          $sql_backup_out .= 'INSERT INTO [SQL_TABLE_PREFIX]'.$table_name.'(';
          for ($it1 = 0; $it1 < $table_length; $it1+=2) {
            $sql_backup_out .= $table_keys[$it1].',';
          }
          $sql_backup_out = substr($sql_backup_out, 0, -1);
          $sql_backup_out .= ') VALUES(';
          for ($it2 = 0; $it2 < $table_length; $it2+=2) {
            $sql_backup_out .= "'".addslashes($table_values[$it2])."',";
          }
          $sql_backup_out = substr($sql_backup_out, 0, -1);
          $sql_backup_out .= ");\n\n";
          $it3++;
        }
        $rep1->closeCursor();
        $id_max++;
        $sql_backup_out .= "-- --------------------------------------------------------\n";
        $sql_backup_out .= "-- Reset de la clé de la table [SQL_TABLE_PREFIX]$table_name\n\n";
        $sql_backup_out .= "ALTER TABLE [SQL_TABLE_PREFIX]$table_name AUTO_INCREMENT =$id_max;\n\n\n";
        $out_txt .= " $it3 entry found.</p>";
      }
    }
    $out_txt .= "<p>Database fully read.</p>";
    
    $out_txt .= "<p>Saving database in file... ";
    try {
      $sql_backup_out = accentshtmlentities($sql_backup_out);
      
      $zip_file->addFromString('sql_db.asc', $sql_backup_out);
      
      $out_txt .= "Database saved in \"sql_db.asc\".</p>";
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= "<p>Error : Cannot save the backup file.</p>";
      print_r($e->getMessage());
    }
    $out_txt .= "<p>Starting images and files backup...</p>";
    foreach($PluginsInfo as $plugin) {
      if($plugin['files_dir_type'] == 'text') {
        $out_txt .= copyDirectoryToZip($root_dir, $zip_file, $plugin['files_dir']);
        $out_txt .= "<p>\"".$plugin['files_dir']."\" files backup done.</p>";
      }
      elseif($plugin['files_dir_type'] == 'texts') {
        foreach($plugin['files_dir'] as $files_dir) {
          $out_txt .= copyDirectoryToZip($root_dir, $zip_file, $files_dir);
          $out_txt .= "<p>\"".$files_dir."\" files backup done.</p>";
        }
      }
      if($plugin['files_dir_type'] == 'file') {
        include $plugin['files_dir'];
        $out_txt .= copyDirectoryToZip($root_dir, $zip_file, $files_dir);
        $out_txt .= "<p>\"".$plugin['files_dir']."\" files backup done.</p>";
      }
      elseif($plugin['files_dir_type'] == 'files') {
        foreach($plugin['files_dir'] as $files_dir_file) {
          include $files_dir_file;
          $out_txt .= copyDirectoryToZip($root_dir, $zip_file, $files_dir);
          $out_txt .= "<p>\"".$files_dir."\" files backup done.</p>";
        }
      }
    }
    $zip_file->close();
    $out_txt .= "<p>Backup done successfully !</p>";
  }
  else {
    $out_txt .= "<p>Error: Cannot create backup ZIP file.</p>";
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
