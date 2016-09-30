<section id="global_pages_article">
  <h1>Gestion des pages globales</h1>
  <article>
    <p><a class="button new" href="#" onclick="showNewGlobalPageForm(); return false;">Nouvelle page globale</a></p>
    <ul>
      <?php   
      $rep2 = $bdd->query('SELECT * FROM '.getTablePrefix().'info ORDER BY id');
      while ($don2 = $rep2->fetch())
      {
        echo '<li class="has_mini"><span class="img_name"> '.getHtmlFromMysql($don2['name']).'</span>
            <a class="button info" href="#" onclick="editGlobalPageInfo(\''.$don2['id'].'\', \''.$don2['name'].'\');">infos</a>
            <a class="button edit" href="global_pages/script/forms.php?page='.$don2['id'].'">edit</a>';
            if($don2['id'] > 2) {echo ' <a class="button delete" href="#" onclick="deleteGlobalPage('.$don2['id'].', \''.$don2['name'].'\'); return false;">delete</a>';}
        echo '</li>';
      }
      $rep2->closeCursor();
      ?> 
    </ul>
    <p><a class="button new" href="#" onclick="showNewGlobalPageForm(); return false;">Nouvelle page globale</a></p>
  </article>
</section>