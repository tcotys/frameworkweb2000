<?php
  if(!isset($backpath)) $backpath = '';
  // ----- initialisation des plugins ----- //
  function loadPlugins($backpath, $bdd) {
    $PluginsInfo = array();
    $plugin_path = array();
    include($backpath.'local_pages/config.php');
    array_push($plugin_path, 'local_pages/');
    include($backpath.'global_pages/config.php');
    array_push($plugin_path, 'global_pages/');
    $plugin_dir = 'plugins/';
    if ($handle = opendir($backpath.$plugin_dir)) {
      while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
          if(is_file($backpath.$plugin_dir.$entry.'/config.php')) {
            include($backpath.$plugin_dir.$entry.'/config.php');
            array_push($plugin_path, $plugin_dir.$entry);
          }
        }
      }
      closedir($handle); 
    }
    else {
      $out_txt .= "<p>Error: Cannot read directory.</p>";
    }
    include($backpath.'backups/config.php');
    array_push($plugin_path, 'backups');
    include($backpath.'website_manager/config.php');
    array_push($plugin_path, 'website_manager/');

    // Check if each plugins are correctly installed, database part
    foreach($PluginsInfo as $plugin_id => $plugin) {
      $PluginsInfo[$plugin_id]['mysql_installed'] = false;
      $PluginsInfo[$plugin_id]['path'] = $plugin_path[$plugin_id];
      if($plugin['db_name_type'] == 'text') {
        if($bdd->query("SHOW TABLES LIKE '".getTablePrefix().$plugin['db_name']."'")->rowCount() == 1) {
          $PluginsInfo[$plugin_id]['mysql_installed'] = true;
        }
      }
      elseif($plugin['db_name_type'] == 'texts') {
        $error = 0;
        foreach($plugin['db_name'] as $plugin_db_name) {
          if($bdd->query("SHOW TABLES LIKE '".getTablePrefix().$plugin_db_name."'")->rowCount() != 1) {
            $error = 1;
          }
        }
        if($error == 0) {
          $PluginsInfo[$plugin_id]['mysql_installed'] = true;
        }
      }
      elseif($plugin['db_name_type'] == 'none') {
          $PluginsInfo[$plugin_id]['mysql_installed'] = true;
      }
    }
    return $PluginsInfo;
  }
  $PluginsInfo = loadPlugins($backpath, $bdd);
?>