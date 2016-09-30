<section id="local_pages_article">
  <h1>Gestion des pages locales</h1>
  <article>
    <p><a class="button new" href="#" onclick="showNewPageForm(); return false;">new page</a></p>
    <ul>
      <?php   
      $rep1 = $bdd->query('SELECT * FROM '.getTablePrefix().'pages ORDER BY id');
      while ($don1 = $rep1->fetch())
      {
        echo '<li class="has_mini"><span class="img_name"> '.getHtmlFromMysql($don1['page_name']).'</span>
            <a class="button info" href="#" onclick="showEditPageInfoForm(\''.$don1['id'].'\', \''.$don1['page_name'].'\', \''.$don1['url_titre'].'\', \''.$don1['attached_to'].'\'); return false;">infos</a>
            <a class="button html" href="local_pages/html/forms.php?page='.$don1['id'].'">HTML</a>
            <a class="button css" href="local_pages/css/forms.php?page='.$don1['id'].'">CSS</a>
            <a class="button javascript" href="local_pages/javascript/forms.php?page='.$don1['id'].'">JavaScript</a>';
            if($don1['id'] > 5) echo ' <a class="button delete" href="#" onclick="deletePage('.$don1['id'].', \''.$don1['page_name'].'\'); return false;">delete</a></li>'; 
      }
      $rep1->closeCursor();
      ?> 
    </ul>
    <p><a class="button new" href="#" onclick="showNewPageForm(); return false;">new page</a></p>
  </article>
</section>