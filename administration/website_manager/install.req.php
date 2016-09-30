<?php
  function installPluginTables($plugin_config, $bdd) {
    $error = 0;
    $out_txt = "";
    if($plugin_config['db_name_type'] == 'text' && $plugin_config['db_create_type'] == "text") {
      $plugin_table_name = $plugin_config['db_name'];
      $plugin_create_table = $plugin_config['db_create'];
      $create_table_text = "CREATE TABLE IF NOT EXISTS ".getTablePrefix().$plugin_table_name."(\n".$plugin_create_table;
      if($bdd->query($create_table_text)) {
        $out_txt .= "<p>Basics websites tables successfully created !</p>";
      }
      else {
        $error = 1;
        $out_txt .= "<p>Error : MySql query failed.</p>";
      }
    }
    elseif ($plugin_config['db_name_type'] == 'texts' &&
            $plugin_config['db_create_type'] == "texts" &&
            count($plugin_config['db_create']) == count($plugin_config['db_name'])) {
      foreach($plugin_config['db_name'] as $table_num => $table_name) {
        $plugin_table_name = $plugin_config['db_name'][$table_num];
        $plugin_create_table = $plugin_config['db_create'][$table_num];
        $create_table_text = "CREATE TABLE IF NOT EXISTS ".getTablePrefix().$plugin_table_name."(\n".$plugin_create_table;
        if($bdd->query($create_table_text)) {
          $out_txt .= "<p>Basics websites tables successfully created !</p>";
        }
        else {
          $error = 1;
          $out_txt .= "<p>Error : MySql query failed.</p>";
        }
      }
    }
    else {
      $error = 1;
      $out_txt .= "<p>Error : <em>db_name_type</em> other than <em>text</em> and <em>texts</em> not supported yet...</p>";
    }
    if($error == 0) {
      $out_txt .= "<p>Plugin table(s) installed successfully !</p>";
    }
    else {
      $out_txt .= "<p>Plugin table(s) installed with error(s).</p>";
    }
    return $out_txt;
  }
  function extractPluginFiles($zip_path, $debug = false) {
    $out_txt = "";
    $tmp_extract_folder = getAdminFolder().'/tmp/';
    if(!is_dir($tmp_extract_folder)) {
      mkdir($tmp_extract_folder, 0777);
      chmod($tmp_extract_folder, 0777);
      if($debug) {$out_txt .= "<p>Tmp dir created.</p>";}
    }
    else {
      if($debug) {$out_txt .= "<p>Tmp dir already exist.</p>";}
      $out_txt .= clearDir($tmp_extract_folder, false, $debug);
      chmod($tmp_extract_folder, 0777);
    }
    $zip_file = new ZipArchive;
    if($zip_file->open($zip_path, ZipArchive::CREATE) === TRUE) {
      if($debug) {$out_txt .= "<p>Backup ZIP file read.</p>";}
      $out_txt .= copyZipToDirectory($zip_file, $root_dir, $tmp_extract_folder);
      $admin_files_path = $tmp_extract_folder.'admin_files/';
      $users_files_path = $tmp_extract_folder.'users_files/';
      $out_txt .= copyDirectoryFiles($admin_files_path, getAdminFolder().'/', $debug);
      $out_txt .= copyDirectoryFiles($users_files_path, getSiteFolder().'/',  $debug);
      if($zip_file->close()) {if ($debug) {$out_txt .= "<p>Zip file closed.</p>";}}
      $out_txt .= deleteDir($tmp_extract_folder, $debug);
      if(unlink($zip_path)) {if ($debug) {$out_txt .= "<p>Zip file deleted.</p>";}}
      $out_txt .= "<p>Plugin files extracted finished.</p>";
    }
    return $out_txt;
  }
?>