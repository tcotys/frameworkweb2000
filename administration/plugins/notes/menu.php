<section id="notes_article">
  <h1>Gestion du Bloc Notes</h1>
  <article>
    <p><a class="button new" href="#" onclick="showNewNoteForm(); return false;">nouvelle note</a></p>
    <ul>
      <?php   
      $rep1 = $bdd->query('SELECT * FROM '.getTablePrefix().'notes ORDER BY id');
      while ($don1 = $rep1->fetch())
      {
        echo '<li class="has_mini"><span class="img_name"> '.getHtmlFromMysql($don1['note_name']).'</span>
            <a class="button info" href="#" onclick="showEditNoteInfoForm(\''.$don1['id'].'\', \''.$don1['note_name'].'\'); return false;">infos</a>
            <a class="button edit" href="plugins/notes/notepad/forms.php?note='.$don1['id'].'">edit</a>
            <a class="button delete" href="#" onclick="deleteNote('.$don1['id'].', \''.$don1['note_name'].'\'); return false;">delete</a></li>'; 
      }
      $rep1->closeCursor();
      ?> 
    </ul>
    <p><a class="button new" href="#" onclick="showNewNoteForm(); return false;">nouvelle note</a></p>
  </article>
</section>
