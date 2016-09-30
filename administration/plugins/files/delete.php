<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'files_article';
  
  $out_txt = '<h2>Suprresion d\'un fichier</h2>';
  $error = 0;
  if(is_numeric($_POST['file']) ) {
    $file_id = $_POST['file'];
    try {
      $rep1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'files WHERE id=:file_id');
      $rep1->execute(array('file_id'=>$file_id));
      $don1 = $rep1->fetch();
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= $e->getMessage().'<br />';
    }
    if(unlink('../../../'.$don1['url'])) {
      try {
        $req2 = $bdd->prepare('DELETE FROM '.getTablePrefix().'files WHERE id=:old_id');
        $req2->execute(array( 'old_id' => $file_id));
      }
      catch (Exception $e) {
        $error = 1;
        $out_txt .= $e->getMessage().'<br />';
      }
      $out_txt .= '<p>Suppression effectuée !</p>';
    }
    else {
      $error = 1;
      $out_txt .= "<p>Erreur dans la suppression du fichier...</p>";
    }
  }
  else {
    $error = 1;
    $out_txt .= "<p>Erreur: Le fichier n'existe pas...</p>";
  }
  echo $out_txt;
  if ($error == 0) {
    $_SESSION['message'] .= $out_txt;
    header('Location: ../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
