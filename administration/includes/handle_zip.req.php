<?php

function copyDirectoryToZip($in_dir, $zip_file, $sub_dir, $debug = false) {
  if($debug) {$out_txt = "<p>Start reading directory: $sub_dir ...</p>";}
  if ($handle = opendir($in_dir.$sub_dir)) {
    $zip_file->addEmptyDir($sub_dir);
    if($debug){$out_txt .= "<ul>";}
    while (false !== ($entry = readdir($handle))) {
      if($debug){$out_txt .= "<li>$entry : ";}
      if ($entry != "." && $entry != "..") {
        if(is_file($in_dir.$sub_dir.$entry)) {
          if($debug){$out_txt .= "file</li>";}
          $zip_file->addFile($in_dir.$sub_dir.$entry,  $sub_dir.$entry);
        }
        else if(is_dir($in_dir.$sub_dir.$entry)) {
          if($debug){$out_txt .= "dir</li>";}
          $out_txt .= copyDirectoryToZip($in_dir, $zip_file, $sub_dir.$entry.'/');
        }
        else if(is_link($in_dir.$sub_dir.$entry)) {
          if (is_file(readlink($in_dir.$sub_dir.$entry))) {
            $zip_file->addFile(readlink($in_dir.$sub_dir.$entry),  $sub_dir.$entry);
          }
          else if (is_dir(readlink($in_dir.$sub_dir.$entry))) {
            $out_txt .= copyDirectoryToZip($in_dir, $zip_file, $sub_dir.$entry.'/');
          }
        }
        else {
          if($debug){$out_txt .= "unknown</li>";}
        }
      }
    }
    if($debug){$out_txt .= "</ul>";}
    closedir($handle); 
  }
  else
  {
    $out_txt .= "<p>Error: Cannot read directory.</p>";
  }
  return $out_txt;
}

function copyZipToDirectory($zip_file, $out_dir, $sub_dir, $debug = false) {
  if($debug){$out_txt = "<p>Start reading directory: $sub_dir ...</p>";}
  if($debug){$out_txt .= "<ul>";}
  for($i = 0; $i < $zip_file->numFiles; $i++) {
      $zip_filename = $zip_file->getNameIndex($i);
      if (preg_match('#^'.$sub_dir.'#', $zip_filename)) {
        if($debug){$out_txt .= "<li>".$zip_filename."</li>";}
        $zip_file->extractTo($out_dir, array($zip_filename));
//           chmod($out_dir.$zip_filename, 0777);
      }
  }
  if($debug){$out_txt .= "</ul>";}
  return $out_txt;
}
?>