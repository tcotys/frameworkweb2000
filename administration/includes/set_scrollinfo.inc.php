<?php
  if (isset($_POST['scrollInfo'])) {
    $_SESSION['scrollInfo'] = $_POST['scrollInfo'];
  }
  else {
    $_SESSION['scrollInfo'] = 0;
  }
?>