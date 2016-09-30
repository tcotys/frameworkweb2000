<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'sounds_tracks_article';
  
  $out_txt = "<h2>Edition de piste audio</h2>";
  $error = 0;
  if(isset($_POST['track_id']) && isset($_POST['track_name']) && isset($_POST['track_author'])) {
    $track_id       = intval($_POST['track_id']);
    $track_name     = setHtmlToMysql($_POST['track_name']);
    $track_author   = setHtmlToMysql($_POST['track_author']);
    $req = $bdd->prepare('UPDATE '.getTablePrefix().'sounds_tracks
                       SET name   = :name,
                           author = :author
                     WHERE id     = :track_id');
    if($req->execute(array('name'     => $track_name,
                           'author'   => $track_author,
                           'track_id' => $track_id))) {
      $out_txt .= "<p>Track basic info updated.</p>";
   }
   if(isset($_FILES['track_cover']) && $_FILES['track_cover']['error'] == 0) {
    $cover_infos = pathinfo($_FILES['track_cover']['name']);
    $cover_filetype = strtolower($cover_infos['extension']);
    if($cover_filetype == 'jpeg') {$cover_filetype = 'jpg';}
    $accepted_filetypes = array('jpg', 'gif', 'png', 'tiff', 'svg');
    
    if (in_array($cover_filetype, $accepted_filetypes)) {
      $out_txt .= "<p>New track cover detected...</p>";
      $cover_filename = $track_id.'.'.$cover_filetype;
      $cover_folder   = '../../../../sounds/';
      if(move_uploaded_file($_FILES['track_cover']['tmp_name'], $cover_folder.$cover_filename)) {
        $out_txt .= "<p>New track cover uploaded.</p>";
        $req = $bdd->prepare('UPDATE '.getTablePrefix().'sounds_tracks SET cover_type=:cover_type WHERE id=:track_id');
        if($req->execute(array('cover_type'=>$cover_filetype, 'track_id'=>$track_id))) {
          $out_txt .= "<p>New cover linked to track.</p>";
        }
        else {
          $error = 1;
          $out_txt .= "<p>Error : Cannot link cover to track.</p>";
        }
      }
      else {
        $error = 1;
        $out_txt .= "<p>Error : Cannot upload new cover.</p>";
      }
    }
    else {
      $error = 1;
      $out_txt .= '<p>Error : Wrong cover filetype.</p>';
    }
   }
    $_SESSION['script'] = "";
//     $_SESSION['script'] = "showEditTrackForm('$track_id', '$track_name', '$track_author', '$cover_filetype');";
  }
  else {
    $error = 1;
    $out_txt .= "<p>Error: Wrong input parameters.</p>";
  }
  if ($error == 0) {
    $_SESSION['message'] = $out_txt;
    header('Location: ../../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
