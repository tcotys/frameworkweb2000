<?php
function copyDirFiles($in_dir, $out_dir, $sub_dir = '', $debug = false) {
  if($debug) {$out_txt = "<p>Start reading directory: $sub_dir ...</p>";}
  if ($handle = opendir($in_dir.$sub_dir)) {
    if(!file_exists($out_dir.$sub_dir)) {
      mkdir($out_dir.$sub_dir, 0777);
    }
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        if(is_file($in_dir.$sub_dir.$entry)) {
          copy($in_dir.$sub_dir.$entry, $out_dir.$sub_dir.$entry);
        }
        else if(is_link($in_dir.$sub_dir.$entry)) {
          symlink(readlink($in_dir.$sub_dir.$entry), $out_dir.$sub_dir.$entry);
        }
        else if(is_dir($in_dir.$sub_dir.$entry)) {
          $out_txt .= copyDirectoryFiles($in_dir, $out_dir, $sub_dir.$entry.'/');
        }
      }
    }
    closedir($handle); 
  }
  else
  {
    $out_txt .= "<p>Error: Cannot read directory.</p>";
  }
  return $out_txt;
}
function copyDirectoryFiles($in_dir, $out_dir, $sub_dir = '', $debug = false) {
  return copyDirFiles($in_dir, $out_dir, $sub_dir, $debug);
}
function deleteDir($dir_url, $debug = false) {
  $out_txt = '';
  if($debug){$out_txt .= "<p>Deleting directory: $dir_url ...</p>";}
  if($debug) {$out_txt .= "<ul>";}
  if ($handle = opendir($dir_url)) {
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        if(is_file($dir_url.$entry)) {
          if(unlink($dir_url.$entry)){
            if($debug) {$out_txt .= "<li>File: $entry deleted.</li>";}
          }
          else {
            if($debug) {$out_txt .= "<li>Error: Cannot delete file : $entry.</li>";}
          }
        }
        else if(is_link($dir_url.$entry)) {
          if(unlink($dir_url.$entry)){
            if($debug) {$out_txt .= "<li>Link: $entry deleted.</li>";}
          }
          else {
            if($debug) {$out_txt .= "<li>Error: Cannot delete link : $entry.</li>";}
          }
        }
        else if(is_dir($dir_url.$entry)) {
          $out_txt .= deleteDir($dir_url.$entry.'/', $debug);
        }
      }
    }
    closedir($handle); 
    if($debug){$out_txt .= "</ul>";}
    if(rmdir($dir_url)){
      if($debug) {$out_txt .= "<p>Folder deleted.</p>";}
    }
    else {
      if($debug) {$out_txt .= "<p>Error: Cannot delete folder : $dir_url.</p>";}
    }
  }
  else
  {
    $out_txt .= "<p>Error: Cannot read directory.</p>";
  }
  return $out_txt;
}
function clearDir($dir_url, $only_files = false, $debug = false) {
  $out_txt = '';
  if($debug){$out_txt .= "<p>Clearing directory: $dir_url ...</p>";}
  if($debug) {$out_txt .= "<ul>";}
  if ($handle = opendir($dir_url)) {
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        if(is_file($dir_url.$entry)) {
          if(unlink($dir_url.$entry)){
            if($debug) {$out_txt .= "<li>File: $entry deleted.</li>";}
          }
          else {
            if($debug) {$out_txt .= "<li>Error: Cannot delete file : $entry.</li>";}
          }
        }
        else if(is_link($dir_url.$entry)) {
          if(unlink($dir_url.$entry)){
            if($debug) {$out_txt .= "<li>Link: $entry deleted.</li>";}
          }
          else {
            if($debug) {$out_txt .= "<li>Error: Cannot delete link : $entry.</li>";}
          }
        }
        else if(is_dir($dir_url.$entry)) {
          if($only_files) {$out_txt .= clearDir($dir_url, $only_files, $debug);}
          else {$out_txt .= deleteDir($dir_url.$entry.'/', $debug);}
        }
      }
    }
    closedir($handle); 
    if($debug){$out_txt .= "</ul>";}
  }
  else
  {
    $out_txt .= "<p>Error: Cannot read directory.</p>";
  }
  return $out_txt;
}

?>