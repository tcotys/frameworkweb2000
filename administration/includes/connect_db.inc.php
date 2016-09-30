<?php
//   require_once(realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php'));
  try {
      $bdd = new PDO('mysql:host='.getDBhost().';dbname='.getDBname(), getDBusername(), getDBpassword());
  }
  catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
  }
?>
