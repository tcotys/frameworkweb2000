<?php
  function deleteVideoFiles($vid_dir, $vid_id, $ext, $debug = false) {
    if ($handle = opendir($vid_dir)) {
      if($debug){$out_txt .= "<ul>";}
      while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
          $entry_details = explode('.', $entry);
          $entry_id      = $entry_details[0];
          $entry_ext     = $entry_details[1];
          if($entry_id == $vid_id && in_array($entry_ext, $ext)) {
            if(unlink ($vid_dir.$entry)) {
              if($debug) {$out_txt .= "<li>$entry deleted</li>";}
            }
            else {
              if($debug) {$out_txt .= "<li>Cannot delete $entry</li>";}
            }
          }
        }
      }
      if($debug){$out_txt .= "</ul>";}
      closedir($handle); 
    }
    else  {
      $out_txt .= "<p>Error: Cannot read directory.</p>";
    }
    return $out_txt;
  }
?>