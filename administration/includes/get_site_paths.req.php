<?php
  function getAdminFolder() {
    $dir_array = explode('/',dirname(__FILE__));
    array_pop($dir_array);
    return implode('/', $dir_array);
//     $actu_dir = getcwd();
//     if(substr($actu_dir, -1) != '/') {
//       $actu_dir .= '/';
//     }
//     $actu_dir = explode('/',$actu_dir );
//     
//     $site_dir = $_SERVER['DOCUMENT_ROOT'];
//     if(substr($site_dir, -1) != '/') {
//       $site_dir .= '/';
//     }
//     $site_dir = explode('/',$site_dir );
//     
//     $admin_dir = array_slice($actu_dir, 0, count($site_dir));
//     
//     return implode('/', $admin_dir).'/';
  }
  function getSiteFolder() {
    return realpath(getAdminFolder().getWebsitePath());
//     return ;
//     $site_dir = $_SERVER['DOCUMENT_ROOT'];
//     if(substr($site_dir, -1) == '/') {
//       return $site_dir;
//     }
//     else {
//       return $site_dir.'/';
//     }
  }
  function getRelativeDir($dir1, $dir2) {
    $dir1 = explode('/', $dir1);
    $dir2 = explode('/', $dir2);
//     $dir1     = explode('/', getDir());
//     $dir2     = explode('/', getDir2());
    
//     $dir1     = explode('/', '/var/lib/test/plouf1');
//     $dir2     = explode('/', '/var/lib/test2/prout/caca/truc/machin');

    $dir1_len = count($dir1);
    $dir2_len = count($dir2);
    $min_len  = min($dir1_len, $dir2_len);
    $max_len  = max($dir1_len, $dir2_len);

    $reldir12 = array();
//     $reldir21 = array();
    for($it1 = 0; $it1 < $max_len; $it1++) {
      if($it1 < $min_len) {
        if($dir1[$it1] != $dir2[$it1]) {
          array_push($reldir12, $dir2[$it1]);
          array_unshift($reldir12, '..');
          
//           array_push($reldir21, $dir1[$it1]);
//           array_unshift($reldir21, '..');
        }
      }
      elseif ($it1 > $dir1_len-1) {
        array_push($reldir12, $dir2[$it1]);
//         array_unshift($reldir21, '..');
      }
      else {
        array_unshift($reldir12, '..');
//         array_push($reldir21, $dir1[$it1]);
      }
    }
    return (count($reldir12) == 0)?'.':implode('/', $reldir12);
  }
  function getBackPath() {
    $admin_dir  = getAdminFolder();
    $actual_dir = getcwd();
    return getRelativeDir($actual_dir, $admin_dir).'/';
    
//     $admin_dir = explode('/',$admin_dir );
//     $actu_dir  = getcwd();
//     if(substr($actu_dir, -1) != '/') {
//       $actu_dir .= '/';
//     }
//     $actu_dir = explode('/',$actu_dir );
//     
//     $nb_back_dir = count($actu_dir)-count($admin_dir);
//     
//     return str_repeat('../',$nb_back_dir);
  }
?>