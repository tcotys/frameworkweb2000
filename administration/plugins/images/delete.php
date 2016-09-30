<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'images_article';
  
  $out_txt = '<h2>Suprresion d\'une image</h2>';
  if(is_numeric($_POST['img']) )
  {
    $img_id = $_POST['img'];
    try {
      $rep1 = $bdd->prepare('SELECT * FROM '.getTablePrefix().'img WHERE id=:img_id');
      $rep1->execute(array('img_id'=>$img_id));
      $don1 = $rep1->fetch();
    }
    catch (Exception $e) {
      $error = 1;
      $out_txt .= $e->getMessage().'<br />';
    }
    if(unlink('../../../'.$don1['url'])) {
      try {
        $req2 = $bdd->prepare('DELETE FROM '.getTablePrefix().'img WHERE id=:old_id');
        $req2->execute(array( 'old_id' => $img_id));
      }
      catch (Exception $e) {
        $error = 1;
        $out_txt .= $e->getMessage().'<br />';
      }
      $out_txt .= '<p>Suppression effectuée !</p>';}
    else {
      $out_txt .= "<p>Erreur dans la suppression du fichier...</p>";}
  }
  else
  {
    $error = 1;
    $out_txt .= "<p>Error : Wrong input parameters...</p>";
  }
  if ($error == 0) {
    $_SESSION['message'] = $out_txt;
    header('Location: ../../index.php');
  }
  else
  {
    showBasicAdminHTML($out_txt, getSiteName());
  }
?>
