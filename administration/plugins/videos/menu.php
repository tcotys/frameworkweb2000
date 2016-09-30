<section id="videos_article">
  <h1>Gestion des Vidéos</h1>
  <article>
  <p><a href="#" onclick="showNewVideoForm(); return false;" class="button new">new video</a></p>
  <ul>
    <?php
      $rep5 = $bdd->query('SELECT * FROM '.getTablePrefix().'videos ORDER BY id');

      while ($don5 = $rep5->fetch())
      {
        echo '
          <li class="has_mini">
          <img  src="../videos/'.$don5['id'].'.jpg" />
          <span class="img_name" >'.$don5['name'].'</span>
            <a class="button info" href="#" onclick="showEditVideoForm(\''.$don5['id'].'\', \''.$don5['name'].'\', \''.$don5['width'].'\', \''.$don5['height'].'\', \''.$don5['type'].'\', \''.$don5['source'].'\') ; return false;">infos</a>
            <a class="button delete" href="#" onclick="deleteVideo('.$don5['id'].', \''.$don5['name'].'\');return false;">delete</a></li>';
      }
      $rep5->closeCursor();
    ?>
  </ul>
  <p><a href="#" onclick="showNewVideoForm(); return false;" class="button new">new video</a></p>
  </article>
</section>  