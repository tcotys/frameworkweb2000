<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'website_manager_article';
  $error = 0;
  $out_txt = "";
  if(   isset($_POST['website_name']) && isset($_POST['db_host'])     && isset($_POST['db_name'])
     && isset($_POST['table_prefix']) && isset($_POST['db_username']) && isset($_POST['db_password'])
     && isset($_POST['website_path'])) {
    
    
    if ( preg_match('#[;\t\n\r\'"<>]#',   $_POST['website_name'])) {$error = 1;$out_txt .= "<p>Error : website_name</p>";};
    if (!preg_match("#^[a-z0-9._-]+$#",   $_POST['db_host'])     ) {$error = 1;$out_txt .= "<p>Error : db_host</p>";};
    if (!preg_match("#^[\w]+$#",          $_POST['db_name'])     ) {$error = 1;$out_txt .= "<p>Error : db_name</p>";};
    if (!preg_match("#^[\w]+$#",          $_POST['table_prefix'])) {$error = 1;$out_txt .= "<p>Error : table_prefix</p>";};
    if (!preg_match("#^[\w]{1,16}$#",     $_POST['db_username']) ) {$error = 1;$out_txt .= "<p>Error : db_username</p>";};
    if ( preg_match('#[\s\'"]#',          $_POST['db_password']) ) {$error = 1;$out_txt .= "<p>Error : db_password</p>";};
//     if ( preg_match("#;#",              $_POST['db_password']) ) {$entry_test = false;};

    if($error == 0) {
      $website_name = $_POST['website_name'];
      $website_path = $_POST['website_path'];
      $db_host      = $_POST['db_host'];
      $db_name      = $_POST['db_name'];
      $table_prefix = $_POST['table_prefix'];
      $db_username  = $_POST['db_username'];
      $db_password  = $_POST['db_password'];
      $config_file_txt = "<?php
  function getSiteName() {
    return '".$website_name."';
  }
  function getWebsitePath() {
    return '".$website_path."';
  }
  function getTablePrefix() {
    return '".$table_prefix."';
  }
  function getDBhost() {
    return '".$db_host."';
  }
  function getDBname() {
    return '".$db_name."';
  }
  function getDBusername() {
    return '".$db_username."';
  }
  function getDBpassword() {
    return '".$db_password."';
  }
?>";
      $config_file = fopen("../../config.php", 'w');
      if(fwrite($config_file, $config_file_txt)) {
        fclose($config_file);
//         chmod("../../config.php", 0755);
        $out_txt .= "<p>Admin config file sucessfully created !</p>";
      }
      else {
        $out_txt .= "<p>Error : Cannot write the config file...</p>";
        $error = 1;
      }
      $config_file = fopen(dirname(__FILE__).'/../../'.$website_path.'includes/config.php', 'w');
      if(fwrite($config_file, $config_file_txt)) {
        fclose($config_file);
//         chmod("../../config.php", 0755);
        $out_txt .= "<p>Website config file sucessfully created !</p>";
      }
      else {
        $out_txt .= "<p>Error : Cannot write the config file...</p>";
        $error = 1;
      }
      
    }
    else {
      $error = 1;
      $out_txt .=  "<p>Error : Input parameters badly set.</p>";
    }
  }
  else {
    $out_txt .=  "<p>Error : Wrong input parameters.</p>";
    $error = 1;
  }
  
  // ----- Output message display ----- //
  if ($error == 0) {
    $_SESSION['message'] = $out_txt;
    header('Location: ../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
