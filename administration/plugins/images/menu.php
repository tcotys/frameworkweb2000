<section id="images_article">
  <h1>Gestion des images</h1>
  <article>
  <p><a class="button new" href="#" onclick="showNewImgForm(); return false;">new image</a></p>
  <ul>
    <?php
      $rep3 = $bdd->query('SELECT * FROM '.getTablePrefix().'img ORDER BY id');

      while ($don3 = $rep3->fetch())
      {
        echo '<li class="has_mini">
          <img src="../'.$don3['url'].'" />
          <span class="img_name" >'.$don3['name'].'</span>
            <a class="button info" href="#" onclick="showEditImgForm(\''.$don3['id'].'\', \''.$don3['name'].'\', \''.$don3['url'].'\', \''.$don3['type'].'\'); return false;">infos</a>
            <a class="button delete" href="#" onclick="deleteImg('.$don3['id'].', \''.$don3['name'].'\');return false;">delete</a></li>';
      }
      $rep3->closeCursor();
    ?>
  </ul>
  <p><a class="button new" href="#" onclick="showNewImgForm(); return false;">new image</a></p>
  </article>
</section>  