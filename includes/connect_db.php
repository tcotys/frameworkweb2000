<?php
// try {
//     $bdd = new PDO('mysql:host=tyrasonoqs_db.mysql.db;dbname=tyrasonoqs_db', 'tyrasonoqs_db', 'SgRyb6H9HuCA');
// }
// catch(Exception $e) {
// 	die('Erreur : '.$e->getMessage());
// }
  try {
      $bdd = new PDO('mysql:host='.getDBhost().';dbname='.getDBname(), getDBusername(), getDBpassword());
  }
  catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
  }
?>
