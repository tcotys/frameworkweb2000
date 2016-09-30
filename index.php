<?php
  if(isset($_GET['page'])) {
    if (is_numeric($_GET['page'])) {
    $id_page = $_GET['page'];
    }
    else {
      $id_page = 1;
    }
  }
  else {
    $id_page = 1;
  }
  require_once('includes/config.php');
  require_once('includes/mysqlFunctions.php');
  include('includes/connect_db.php');
  
  $rep1 = $bdd->query('SELECT * FROM '.getTablePrefix().'info ORDER BY id') or die(print_r($bdd->errorInfo()));
  while($don1 = $rep1->fetch())
  {
    $global_name[$don1['id']]    = $don1['name'];
    $global_content[$don1['id']] = getHtmlFromMysql($don1['content']);
  }
  $main_page = $global_content[1];
  
  $rep2 = $bdd->query('SELECT * FROM '.getTablePrefix().'pages WHERE id='.$id_page) or die(print_r($bdd->errorInfo()));
  $don2 = $rep2->fetch();
  
  $local_page_name   = $don2['page_name'];
  $local_attached_to = $don2['attached_to'];
  $local_html        = getHtmlFromMysql($don2['html_content']);
  $local_css         = getHtmlFromMysql($don2['css_content']);
  $local_javascript  = getHtmlFromMysql($don2['javascript_content']);
  
  $main_page = preg_replace('#\[GET_LOCAL_PAGE_NAME\]#', $local_page_name, $main_page);
  $main_page = preg_replace('#\[GET_LOCAL_ATTACHED_TO\]#', $local_attached_to, $main_page);
  $main_page = preg_replace('#\[GET_LOCAL_HTML\]#', $local_html, $main_page);
  $main_page = preg_replace('#\[GET_LOCAL_CSS\]#', $local_css, $main_page);
  $main_page = preg_replace('#\[GET_LOCAL_JAVASCRIPT\]#', $local_javascript, $main_page);
  for($it1=0; $it1 < 2; $it1++) {
    foreach ($global_content as $global_id => $content)
    {
      $main_page = preg_replace('#\[GET_GLOBAL_PAGE:'.$global_id.'\]#', $global_content[$global_id], $main_page);
    }
  }
//     $main_page = preg_replace('#\[GET_GLOBAL_PAGE:([0-9]+)\]#', $global_content[${1}], $main_page);
//   $main_page = preg_replace('#\[GET_GLOBAL_PAGE:2\]#', $global_content[2],$main_page);
  
  echo $main_page;
?>