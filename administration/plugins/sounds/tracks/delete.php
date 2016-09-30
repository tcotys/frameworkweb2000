<?php
  include_once('../../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'sounds_tracks_article';
  
  $out_txt = "<h2>Suppression d\'une image de la gallerie</h2>";
  $error = 0;
  if(isset($_POST['track_id'])) {
    $track_id       = intval($_POST['track_id']);
    
    $rep1 = $bdd->query('SELECT id,name, tracks FROM '.getTablePrefix().'sounds_playlists ORDER BY id');
    while($don1 = $rep1->fetch()) {
      $tracklist = explode('.', $don1['tracks']);
      $tracklist_id =  $don1['id'];
      $tracklist_name =  $don1['name'];
      
      $tracklist_length = 0;
      $tracklist_new = array();
      foreach($tracklist as $track_loc_pos => $track_loc_id) {
        $track_loc_id = intval($track_loc_id);
        if($track_loc_id != $track_id) {
          array_push($tracklist_new, $track_loc_id);
          $tracklist_length++;
        }
      }
      $out_txt .= "<p>Tracklist length".$tracklist_length."</p>";
      if($tracklist_length == 0) {
        $tracklist = 0;
      }
      else {
        $tracklist = implode('.', $tracklist_new);
      }
      
      
      $req = $bdd->prepare('UPDATE '.getTablePrefix().'sounds_playlists SET tracks=:tracklist WHERE id=:id');
      if($req->execute(array('id'=>$tracklist_id, 'tracklist'=>$tracklist))) {
        $out_txt .= "<p>Track deleted from playlist: ".$tracklist_name.".</p>";
      }
      else {
        $out_txt .= "<p>Warning: Cannot update playlist database.</p>";
      }
    }
    $rep1->closeCursor(); 
    
    $rep2 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'sounds_tracks WHERE id=:track_id');
    $rep2->execute(array('track_id'=>$track_id));
    $don2 = $rep2->fetch();
    if($don2['type'] == 'local') {
      $track_url = '../../../../sounds/'.$track_id.'.'.$don2['source'];
      if(unlink($track_url)) {
        $out_txt .= "<p>Audio file deleted.</p>";
      }
      else {
        $out_txt .= "<p>Error: Cannot delete audio file ($track_url).</p>";
      }
    }
    $rep2->closeCursor();
    $req = $bdd->prepare('DELETE FROM '.getTablePrefix().'sounds_tracks WHERE id=:track_id');
    if($req->execute(array('track_id'=>$track_id))) {
      $out_txt .= "<p>Tracks deleted from tracks database.</p>";
    }
    else {
      $out_txt .= "<p>Error: Cannot delete tracks from tracks database.</p>";
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
