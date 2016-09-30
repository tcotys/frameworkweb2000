<?php
  include_once('../../includes/libraries_includer.inc.php');
  require_once('handle_videos.req.php');
  $_SESSION['anchored_page'] = 'videos_article';
  
  $out_txt = '<h2>Suprresion d\'une vidéo</h2>';
  $error = 0;
  if(is_numeric($_POST['video']) ) {
    $vid_id = $_POST['video'];
    $ext = array('jpg', 'png', 'gif', 'ogv', 'mp4', 'webm');
  
//     $root_dir = getcwd();
//     $root_dir = explode('/',$root_dir );
//     array_pop($root_dir);
//     array_pop($root_dir);
//     array_pop($root_dir);
//     $root_dir = implode('/', $root_dir).'/';
    $root_dir = '../../../';
    
    $out_txt .= deleteVideoFiles($root_dir.'videos/', $vid_id, $ext, true);
    try {
      $req2 = $bdd->prepare('DELETE FROM '.getTablePrefix().'videos WHERE id=:old_id');
      $req2->execute(array( 'old_id' => $vid_id));
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= $e->getMessage().'<br />';
    }
    $out_txt .= '<p>Suppression effectuée !</p>';
  }
  else {
    $error = 1;
    $out_txt .= "<p>Error: Wrong input parameters...</p>";
  }
  if ($error == 0) {
    $_SESSION['message'] .= $out_txt;
    header('Location: ../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
