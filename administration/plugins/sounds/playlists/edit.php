<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'sounds_playlists_article';
  
  $out_txt = "<h2>Edition des info de gallerie</h2>";
  $error = 0;
  if(isset($_POST['playlist_id']) && isset($_POST['name']) && isset($_POST['design']) && isset($_POST['tracks'])) {
    $playlist_id  = intval($_POST['playlist_id']);
    $name         = setHtmlToMysql($_POST['name']);
    $style        = setHtmlToMysql($_POST['design']);
    $tracklist    = $_POST['tracks'];
    
    $tracklist_length = 0;
    $tracklist = explode('.', $tracklist);
    $tracklist_new = array();
    foreach($tracklist as $track_pos => $track_id) {
      $track_id = intval($track_id);
      if($track_id != 0) {
        $tracklist_new[$track_pos] = $tracklist[$track_pos];
//         $track_pos = array_search(0, $tracklist);
//         $tracklist = array_splice($tracklist, $track_pos, 1);
        $tracklist_length++;
      }
    }
    if($tracklist_length == 0) {
      $tracklist = 0;
    }
    else {
      $tracklist = implode('.', $tracklist_new);
    }
    $req = $bdd->prepare('UPDATE '.getTablePrefix().'sounds_playlists
                       SET name   = :name,
                           style  = :style,
                           tracks = :tracks
                     WHERE id     = :p_id');
    if($req->execute(array('name'   => $name,
                           'style'  => $style,
                           'tracks' => $tracklist,
                           'p_id'   => $playlist_id))) {
      $out_txt .= "<p>Gallery Updated.</p>";
    }
    else {
      $error = 1;
      $out_txt .= "<p>Error: Cannot update database.</p>";
    }
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
