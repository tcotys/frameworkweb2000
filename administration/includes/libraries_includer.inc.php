<?php
  session_start();
  $this_dir = dirname(__File__).DIRECTORY_SEPARATOR;
  require_once($this_dir.'config.php');
  require_once($this_dir.'get_site_paths.req.php');
  require_once($this_dir.'show_errorpage.req.php');
  require_once($this_dir.'mysql_formatting.req.php');
  require_once($this_dir.'handle_files.req.php');
  require_once($this_dir.'handle_zip.req.php');
  require_once($this_dir.'is_animated_gif.req.php');
  require_once($this_dir.'upload_messages.req.php');
  
  include_once($this_dir.'set_scrollinfo.inc.php');
  include_once($this_dir.'connect_db.inc.php');
  unset($this_dir);
?>
