<section id="galleries_article">
  <h1>Gestion des galleries photos</h1>
  <article>
    <p><a href="#" onclick="showNewGalleryForm(); return false;" class="button new">new gallery</a></p>
    <ul>
      <?php
        $rep6 = $bdd->query('SELECT * FROM '.getTablePrefix().'galleries ORDER BY id');

        while ($don6 = $rep6->fetch())
        {
          echo '
            <li class="has_mini">
            <img src="../galleries/'.$don6['id'].'/mini/1.jpg" />
            <span class="img_name">'.$don6['name'].' <small>(par '.$don6['author'].')</small></span>
              <a class="button info" href="#" onclick="showEditGalleryForm(\''.$don6['id'].'\', \''.$don6['name'].'\', \''.$don6['author'].'\', '.$don6['mini_width'].', '.$don6['mini_height'].', '.$don6['large_width'].', '.$don6['large_height'].') ; return false;">infos</a>
              <a class="button add" href="#" onclick="showNewGalleryImagesForm('.$don6['id'].', \''.$don6['name'].'\'); return false;">add images</a>
              <a class="button see" href="#" onclick="showEditGalleryImagesForm(\''.$don6['id'].'\', \''.$don6['name'].'\', \''.$don6['author'].'\', '.$don6['nb_img'].') ; return false;">voir</a>
              <a class="button download" href="plugins/galleries/download.php?id='.$don6['id'].'">download</a>
              <a class="button delete" href="#" onclick="deleteGallery('.$don6['id'].', \''.$don6['name'].'\');return false;">delete</a></li>';
        }
        $rep6->closeCursor();
      ?>
    </ul>
    <p><a href="#" onclick="showNewGalleryForm(); return false;" class="button new">new gallery</a></p>
  </article>
</section>
