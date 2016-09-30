<section id="backups_article">
  <h1>Gestion des backups</h1>
  <article>
    <p>
      <a class="button load" href="#" onclick="showDatabaseUploadForm(); return false;">Upload a backup file</a>
      <a class="button new" href="backups/bank.php">Make a backup now</a>
    </p>
    <ul>
    <?php 
      $admin_dir = getcwd();
      $backup_dir_url = $admin_dir.'/backups/';
      if($backup_dir = opendir($backup_dir_url)) {
        while (false !== ($backup_file = readdir($backup_dir))) {
          if ($backup_file != "." && $backup_file != ".." and preg_match('#.zip$#i', $backup_file)) {
            echo '<li class="has_mini"><span class="img_name">'.$backup_file.'</span>
              <a class="button restore" href="backups/restore.php?file='.$backup_file.'">restore</a>
              <a class="button download" href="backups/'.$backup_file.'">download</a>
              <a class="button delete" href="#" onclick="deleteBackup(\''.$backup_file.'\');">delete</a>
            </li>';
          }
        }
        closedir($backup_dir);
      }
    ?>
    </ul>
    <p>
      <a class="button load" href="#" onclick="showDatabaseUploadForm(); return false;">Upload a backup file</a>
      <a class="button new" href="backups/bank.php">Make a backup now</a>
    </p>
  </article>
</section>