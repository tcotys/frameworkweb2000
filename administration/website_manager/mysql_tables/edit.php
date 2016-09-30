<?php
  include_once('../../includes/libraries_includer.inc.php');
  require_once('../install.req.php');
  $_SESSION['anchored_page'] = 'website_manager_article';
  $out_txt = "";
  $error = 0;
  if(isset($_POST['plugin_id']) && is_numeric($_POST['plugin_id']) && isset($_POST['check'])) {
    $out_txt .= "<p>Checking plugin...</p>";
//     $plugin_id = $_POST['plugin_id']; // bug with the plugin loader -> must be resolved
//     include_once('../../config.php');
//     include_once('../../includes/connect_db.php');

    $backpath = '../../';
    include_once('../../includes/plugins_loader.inc.php');
    if(urlencode($PluginsInfo[$_POST['plugin_id']]['name']) == $_POST['check']) {
      $out_txt .= "<p>Creating table(s)...</p>";
//       include_once('../../includes/mysqlFunctions.php');
      $out_txt .= installPluginTables($PluginsInfo[$_POST['plugin_id']], $bdd);
    }
    else {
      $error = 1;
      $out_txt .= "<p>Error : Plugin check failed.</p>";
      $out_txt .= "<p>Id   : ".$_POST['plugin_id']."</p>";
      $out_txt .= "<p>Post : ".$_POST['check']."</p>";
      $out_txt .= "<p>Data : ".urlencode($PluginsInfo[$_POST['plugin_id']]['name'])."</p>";
    }
  }
  else {
    $out_txt .= "<p>Error : Wrong input parameters.</p>";
    $error = 1;
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
