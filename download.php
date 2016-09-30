<?php
  if (is_numeric($_GET['file'])) {
    require 'includes/config.php';
    require 'includes/filesSavesFunc.inc.php';
    require 'includes/mysqlFunctions.php';
    include 'includes/connect_db.php';
    
    $file_id = $_GET['file'];

    $rep1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'files WHERE id=:file_id');
    $rep1->execute(array('file_id'=>$file_id));
    $don1 = $rep1->fetch();
    
    $filename = $don1['filename'];
    $fileaddr = $don1['url'];
    
    if(is_numeric($_GET['download']) and $_GET['download'] == 1) {
      $download = 1;
    }
    else {
      $download = 0;
    }
    
    envoi_fichier ($filename, $fileaddr, $download);
  }
  else {
    echo "Erreur: Le document n'existe pas...";
  }
?>
