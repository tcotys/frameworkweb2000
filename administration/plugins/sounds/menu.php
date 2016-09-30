<section id="sounds_playlists_article">
  <h1>Audio : Gestion des playlist</h1>
  <article>
    <p><a href="#" onclick="showNewPlaylistForm(); return false;" class="button new">new playlist</a></p>
    <ul>
      <?php
        $rep11 = $bdd->query('SELECT * FROM '.getTablePrefix().'sounds_playlists ORDER BY id');

        while ($don11 = $rep11->fetch())
        {
          echo '
            <li class="has_mini">
            <span class="img_name">'.$don11['name'].'</span>
              <a class="button info" href="#" onclick="showEditPlaylistForm(\''.$don11['id'].'\', \''.$don11['name'].'\', \''.$don11['style'].'\', \''.$don11['tracks'].'\'); return false;">infos</a>
              <a class="button download" href="plugins/sounds/download.php?id='.$don11['id'].'">download</a>
              <a class="button delete" href="#" onclick="deletePlaylist('.$don11['id'].', \''.$don11['name'].'\');return false;">delete</a></li>';
        }
        $rep11->closeCursor();
      ?>
    </ul>
    <p><a href="#" onclick="showNewPlaylistForm(); return false;" class="button new">new playlist</a></p>
  </article>
</section>

<section id="sounds_tracks_article">
  <h1>Gestion des pistes</h1>
  <article>
    <p><a href="#" onclick="showNewTracksForm(); return false;" class="button new">new track</a></p>
    <ul id="sounds_track_list">
      <?php
        $rep12 = $bdd->query('SELECT * FROM '.getTablePrefix().'sounds_tracks ORDER BY id');
        while ($don12 = $rep12->fetch())
        {
          echo '
          <li class="has_mini">';
          if($don12['cover_type'] != "" && $don12['cover_type'] != "none") {
            echo '
             <img src="../sounds/'.$don12['id'].'.'.$don12['cover_type'].'" />';
          }
          else {
            echo '
             <img src="../sounds/no-cover.png" />';
          }
          echo '
            <span class="img_name">'.$don12['name'].'<small>(by "'.$don12['author'].'")</small></span>
              <a class="button info" href="#" onclick="showEditTrackForm(\''.$don12['id'].'\', \''.setHtmlToMysql($don12['name']).'\', \''.setHtmlToMysql($don12['author']).'\', \''.$don12['cover_type'].'\') ; return false;">info</a>
              <a class="button download" href="../sounds/'.$don12['id'].'.'.$don12['source'].'" target="_blank" ">listen</a>
              <a class="button delete" href="#" onclick="deleteTrack('.$don12['id'].', \''.$don12['name'].'\');return false;">delete</a></li>';
        }
        $rep12->closeCursor();
      ?>
    </ul>
    <p><a href="#" onclick="showNewTracksForm(); return false;" class="button new">new track</a></p>
  </article>
</section>
