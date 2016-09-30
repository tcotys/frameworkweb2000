<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'sounds_playlists_article';
  $out_txt = "<h2>Creation d\'une archive de gallerie</h2>";
  $error = 0;
  
  $mime2ext = array(
    'audio/mpeg3'     => 'mp3',
    'audio/x-mpeg-3'  => 'mp3',
    'video/mpeg'      => 'mp3',
    'video/x-mpeg'    => 'mp3',
    'audio/aiff'      => 'aif',
    'audio/x-aiff'    => 'aif',
    'audio/aiff'      => 'aifc',
    'audio/x-aiff'    => 'aifc',
    'audio/aiff'      => 'aiff',
    'audio/x-aiff'    => 'aiff',
    'audio/wav'       => 'wav',
    'audio/x-wav'     => 'wav',
    'application/ogg' => 'ogg',
    'video/mp4'       => 'mp4'
  );
  
  if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $playlist_id  = intval($_GET['id']);
    $rep1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'sounds_playlists WHERE id=:playlist_id');
    $rep1->execute(array('playlist_id'=>$playlist_id));
    $don1 = $rep1->fetch();
    
    $album = $don1['name'];
    $tracklist = explode('.', $don1['tracks']);
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    $all_tracks = array();
    $rep2 = $bdd->query('SELECT * FROM '.getTablePrefix().'sounds_tracks ORDER BY id');
    while($don2 = $rep2->fetch()) {
      $track_url = "";
      if($don2['type'] == 'local') {
        $track_url = '../../../sounds/'.$don2['id'].'.'.$don2['source'];
        $track_ext = $don2['source'];
      }
      elseif($don2['type'] == 'url') {
        $track_url = $don2['source'];
        $track_ext = $mime2ext[finfo_file($finfo, $track_url)];
      }
      
      if($track_url != "") {
        $all_tracks[intval($don2['id'])] = array(
          'id'         => $don2['id'],
          'title'      => $don2['name'],
          'artist'     => $don2['author'],
          'url'        => $track_url,
          'ext'        => $track_ext,
          'cover_url'  => '../../../sounds/'.$don2['id'].'.'.$don2['cover_type'],
          'cover_ext'  => $don2['cover_type']);
      }
    }
    $rep2->closeCursor();
    finfo_close($finfo);
    
    $zip_url = '../../../sounds/'.$playlist_id.'.zip';
    if(file_exists($zip_url)) {unlink($zip_url);}
    $zip_file = new ZipArchive;
    if($zip_file->open($zip_url, ZipArchive::CREATE) === TRUE) {
      $out_txt .= "<p>Playlist ZIP file created !</p>";
      foreach($tracklist as $track_num => $track_id) {
        $track_info = $all_tracks[intval($track_id)];
        
        $track_newname = ($track_num+1)       .' - '
                        .$track_info['artist'].' - '
                        .$track_info['title'] .'.'
                        .$track_info['ext'];
        $zip_file->addFile($track_info['url'], $track_newname);
        if($track_info['cover_ext'] != "" && $track_info['cover_ext'] != "none") {
          $cover_newname = ($track_num+1)       .' - '
                          .$track_info['artist'].' - '
                          .$track_info['title'] .'.'
                          .$track_info['cover_ext'];;
          $zip_file->addFile($track_info['cover_url'], $cover_newname);
        }
      }
      $zip_file->close();
      $out_txt .= "<p>Tracks saved in ZIP file.</p>";
    }
    else {
      $error = 1;
      $out_txt .= "<p>Error: Cannot create ZIP file.</p>";
    }
  }
  else {
    $error = 1;
    $out_txt .= "<p>Error: Wrong input parameters.</p>";
  }
  
  if($error == 0) {
    $_SESSION['message'] = $out_txt;
    envoi_fichier ($album.'.zip', $zip_url, 1);
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }

?>
