<?php
  include_once('../../includes/libraries_includer.inc.php');
  $_SESSION['anchored_page'] = 'files_article';
  
  $out_txt = "<h2>Ajout d\'un nouveau document</h2>";
  $error = 0;
  
  if(isset($_POST['surname']) && isset($_FILES['file_source']) && $_FILES['file_source']['error'] == 0)
  {
    $surname = htmlspecialchars($_POST['surname']);
    $filename = htmlspecialchars($_FILES['file_source']['name']);
    $out_txt .= "<p>Tentative de mise en ligne du document : ".$surname."(".$filename.")...</p>";
    
    $infosfichier = pathinfo($_FILES['file_source']['name']);
    $filetype = strtolower($infosfichier['extension']);
    $forbidden_filetype = array('exe', 'app', 'sh', 'msi', 'bat', 'apk', 'cmd', 'msc', 'msp', 'mst', 'paf', 'run', 'ini'); 

    if (!in_array($filetype, $forbidden_filetype))
    {
      try {
        $req1 = $bdd->prepare('INSERT INTO '.getTablePrefix().'files(surname, filename, filetype, url)
                            VALUES(:new_surname,:new_name, :new_type, "")');
        $req1->execute(array('new_surname' => $surname, 'new_name'=>$filename, 'new_type' => $filetype));
      }
      catch (Exception $e) {
        $error = 1;
        $out_txt .= $e->getMessage().'<br />';
      }
      $out_txt .= "<p>Enregistrement du document dans la base de données</p>";
      $out_txt .= "<p>Préparation de la sauvegarde du document</p>";
      try {
        $rep2 = $bdd->query('SELECT MAX(id) AS file_id FROM '.getTablePrefix().'files');
        $don2 = $rep2->fetch();
      }
      catch (Exception $e) {
        $error = 1;
        $out_txt .= $e->getMessage().'<br />';
      }
      $file_id = $don2['file_id'];
      $fileaddr = 'files/'.$file_id.'.'.$filetype;
      
      if(move_uploaded_file($_FILES['file_source']['tmp_name'], '../../../'.$fileaddr))
      {
        $out_txt .= "<p>Mise en ligne du document réussie !</p>";
        try {
          $req3 = $bdd->prepare('UPDATE '.getTablePrefix().'files SET url=:new_url WHERE id=:old_id');
          $req3->execute(array('new_url' => $fileaddr, 'old_id' => $file_id));
        }
        catch (Exception $e) {
          $error = 1;
          $out_txt .= $e->getMessage().'<br />';
        }
      }
      else
      {
        $error = 1;
        $out_txt .= "<p>Echec de la mise en ligne... retrait de l'image de la base de données.</p>";
        try {
          $req4 = $bdd->prepare('DELETE FROM '.getTablePrefix().'files WHERE id=:old_id');
          $req4->execute(array( 'old_id' => $file_id));
        }
        catch (Exception $e) {
          $error = 1;
          $out_txt .= $e->getMessage().'<br />';
        }
        $out_txt .= "<p>Retrait de la base de donnée réussie</p>";
      }
    }
    else
    {
      $error = 1;
      $out_txt .= "<p>Erreur : Type de fichier non autorisé.</p>";
    }
  }
  else
  {
    $error = 1;
    $out_txt .= "<p>Erreur... </p>";
    switch ($_FILES['file_source']['error']) {
      case 1:
          $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
          break;
      case 2:
          $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
          break;
      case 3:
          $message = "The uploaded file was only partially uploaded";
          break;
      case 4:
          $message = "No file was uploaded";
          break;
      case 5:
          $message = "Missing a temporary folder";
          break;
      case 6:
          $message = "Failed to write file to disk";
          break;
      case 7:
          $message = "File upload stopped by extension";
          break;

      default:
          $message = "Unknown upload error";
          break;
    } 
    $out_txt .= "<p>".$message."</p>";
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
