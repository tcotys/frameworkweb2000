<?php
function getNewImageSize($w1, $h1, $w2, $h2) {
  if(($w1*$h2)/($h1*$w2) > 1) { // redimentionnement sans déformation
    $w3 = $w2;
    $h3 = $w2*$h1/$w1;
  }
  else {
    $w3 = $h2*$w1/$h1;
    $h3 = $h2;
  }
  return array($w3, $h3);
}

function copyWithoutAnImage($in_dir, $out_dir, $deleted_img, $recursive = false, $debug = false) {
  if ($handle = opendir($in_dir)) {
    if($debug) {$out_txt .= "<p>Folder $entry opened.</p>";}
    if($debug) {$out_txt .= "<ul>";}
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        if(is_file($in_dir.$entry)) {
          $in_size = getimagesize($in_dir.$entry);
          if($in_size['mime'] == "image/gif" || $in_size['mime'] == "image/jpeg" || $in_size['mime'] == "image/png") {
            $entry_split = explode('.', $entry);
            if(is_numeric($entry_split[0])) {
              if($entry_split[0] < $deleted_img) {
                copy($in_dir.$entry, $out_dir.$entry);
                if($debug) {$out_txt .= "<li>Image $entry copied.</li>";}
              }
              elseif ($entry_split[0] > $deleted_img) {
                $entry_new = ($entry_split[0]-1).'.'.$entry_split[1];
                copy($in_dir.$entry, $out_dir.$entry_new);
                if($debug) {$out_txt .= "<li>Image $entry copied as $entry_new.</li>";}
              }
            }
            else {
              copy($in_dir.$entry, $out_dir.$entry);
              if($debug) {$out_txt .= "<li>File $entry copied.</li>";}
            }
          }
          else {
            copy($in_dir.$entry, $out_dir.$entry);
            if($debug) {$out_txt .= "<li>File $entry copied.</li>";}
          }
        }
        elseif(is_link($in_dir.$entry)) {
          symlink(readlink($in_dir.$entry), $out_dir.$entry);
        }
        elseif(is_dir($in_dir.$sub_dir.$entry)) {
          if($recursive) {
            $out_txt .= copyDirectoryFiles($in_dir.$entry, $out_dir.$entry);
          }
        }
      }
    }
    closedir($handle);
    if($debug) {$out_txt .= "</ul>";}
  }
  else
  {
    if($debug) {$out_txt .= "<p>Error: Cannot read directory.</p>";}
  }
  return $out_txt;
}



function copyMoveImage($in_dir, $out_dir, $old_img_id, $new_img_id, $recursive = false, $debug = false) {
  if ($handle = opendir($in_dir)) {
    if($debug) {$out_txt .= "<p>Folder $entry opened.</p>";}
    if($debug) {$out_txt .= "<ul>";}
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        if(is_file($in_dir.$entry)) {
          $in_size = getimagesize($in_dir.$entry);
          if($in_size['mime'] == "image/gif" || $in_size['mime'] == "image/jpeg" || $in_size['mime'] == "image/png") {
            $entry_split = explode('.', $entry);
            if(is_numeric($entry_split[0])) {
              $shift = 0;
              if($entry_split[0]  > $old_img_id) {$shift--;}
              if($entry_split[0]  > $new_img_id) {$shift++;}
              if($entry_split[0] == $new_img_id) {$shift = ($new_img_id>$old_img_id)?-1:+1;}
              if($entry_split[0] == $old_img_id) {$shift = $new_img_id - $old_img_id;}
              $entry_new = ($entry_split[0]+$shift).'.'.$entry_split[1];
              copy($in_dir.$entry, $out_dir.$entry_new);
              if($debug) {$out_txt .= "<li>Image $entry copied as $entry_new.</li>";}
            }
            else {
              copy($in_dir.$entry, $out_dir.$entry);
              if($debug) {$out_txt .= "<li>File $entry copied.</li>";}
            }
          }
          else {
            copy($in_dir.$entry, $out_dir.$entry);
            if($debug) {$out_txt .= "<li>File $entry copied.</li>";}
          }
        }
        elseif(is_link($in_dir.$entry)) {
          symlink(readlink($in_dir.$entry), $out_dir.$entry);
        }
        elseif(is_dir($in_dir.$sub_dir.$entry)) {
          if($recursive) {
            $out_txt .= copyDirectoryFiles($in_dir.$entry, $out_dir.$entry, '');
          }
        }
      }
    }
    closedir($handle);
    if($debug) {$out_txt .= "</ul>";}
  }
  else
  {
    if($debug) {$out_txt .= "<p>Error: Cannot read directory.</p>";}
  }
  return $out_txt;
}

function copyAndResize($in_dir, $out_dir, $max_width, $max_height, $jpeg_only = true, $recursive = false, $debug = false) {
  if ($handle = opendir($in_dir)) {
    if($debug) {$out_txt .= "<p>Folder $entry opened.</p>";}
    if(!file_exists($out_dir)) {
      if(mkdir($out_dir, 0777, true)) {if($debug) {$out_txt .= "<p>Folder $out_dir created.</p>";}}
      else {if($debug){$out_txt .= "<p>Error: Cannot create folder $out_dir.</p>";}}
    }
    if($debug) {$out_txt .= "<ul>";}
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        if(is_file($in_dir.$entry)) {
          $in_size = getimagesize($in_dir.$entry);
          if($in_size['mime'] == "image/gif" || $in_size['mime'] == "image/jpeg" || $in_size['mime'] == "image/png") {
            if($in_size['mime'] == "image/jpeg") {
              $image1 = imagecreatefromjpeg($in_dir.$entry);
            }
            elseif($in_size['mime'] == "image/png") {
              $image1 = imagecreatefrompng($in_dir.$entry);
            }
            elseif($in_size['mime'] == "image/gif") {
              $image1 = imagecreatefromgif($in_dir.$entry);
            }
            $w1 = $in_size[0];
            $h1 = $in_size[1];
            $w2 = $max_width;
            $h2 = $max_height;
            if(($w1*$h2)/($h1*$w2) > 1) { // redimentionnement sans déformation
              $w3 = $w2;
              $h3 = $w2*$h1/$w1;
            }
            else {
              $w3 = $h2*$w1/$h1;
              $h3 = $h2;
            }
            $image2 = imagecreatetruecolor($w3, $h3);
            imagecopyresampled($image2 , $image1, 0, 0, 0, 0, $w3, $h3, $w1, $h1);
            imagedestroy($image1);
            if($jpeg_only || $in_size['mime'] == "image/jpeg") {
              if(imagejpeg($image2 , $out_dir.$entry, 100)){if($debug) {$out_txt .= "<li>Image: $entry copied and resized.</li>";}}
              else {if($debug) {$out_txt .= "<li>Error: Cannot copy image $entry.</li>";}}
            }
            elseif($in_size['mime'] == "image/png") {
              if(imagepng($image2 , $out_dir.$entry, 100)){if($debug) {$out_txt .= "<li>Image: $entry copied and resized.</li>";}}
              else {if($debug) {$out_txt .= "<li>Error: Cannot copy image $entry.</li>";}}
            }
            elseif($in_size['mime'] == "image/gif") {
              if(imagepng($image2 , $out_dir.$entry, 100)){if($debug) {$out_txt .= "<li>Image: $entry copied and resized.</li>";}}
              else {if($debug) {$out_txt .= "<li>Error: Cannot copy image $entry.</li>";}}
            }
            imagedestroy($image2);
          }
          else {
            copy($in_dir.$entry, $out_dir.$entry);
            if($debug) {$out_txt .= "<li>File $entry copied.</li>";}
          }
        }
        elseif(is_link($in_dir.$entry)) {
          symlink(readlink($in_dir.$entry), $out_dir.$entry);
        }
        elseif(is_dir($in_dir.$sub_dir.$entry)) {
          if($recursive) {
            $out_txt .= copyAndResize($in_dir.$entry, $out_dir.$entry, $max_width, $max_height, $jpeg_only, $recursive, $debug);
          }
        }
      }
    }
    closedir($handle);
    if($debug) {$out_txt .= "</ul>";}
  }
  else
  {
    if($debug) {$out_txt .= "<p>Error: Cannot read directory.</p>";}
  }
  return $out_txt;
}
?>