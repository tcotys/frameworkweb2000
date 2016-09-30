<?php
  function getHtmlFromMysql($inputText) {
    return stripslashes($inputText);}
  function setHtmlToMysql($inputText) {
    return addslashes($inputText);}
?>