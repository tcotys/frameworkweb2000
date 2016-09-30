<?php
  include_once('includes/libraries_includer.inc.php');
  
  if(isset($_POST['page']) and isset($_POST['type']) and isset($_POST['content'])) {
    if(is_numeric($_POST['page'])) {
      
      $id      = $_POST['page'];
      $type    = $_POST['type'];
      $content = $_POST['content'];
      
      if($type == 'global') {
        $page_id = 1;
      }
      elseif (preg_match('#^local#', $type)) {
        $page_id = $id;
      }
        
      
      $rep1 = $bdd->query('SELECT * FROM '.getTablePrefix().'info ORDER BY id') or die(print_r($bdd->errorInfo()));
      while($don1 = $rep1->fetch())
      {
        $global_name[$don1['id']]    = $don1['name'];
        $global_content[$don1['id']] = getHtmlFromMysql($don1['content']);
      }
      
      $rep2 = $bdd->query('SELECT * FROM '.getTablePrefix().'pages WHERE id='.$page_id) or die(print_r($bdd->errorInfo()));
      $don2 = $rep2->fetch();
      
      $local_page_name   = $don2['page_name'];
      $local_attached_to = $don2['attached_to'];
      $local_html        = getHtmlFromMysql($don2['html_content']);
      $local_css         = getHtmlFromMysql($don2['css_content']);
      $local_javascript  = getHtmlFromMysql($don2['javascript_content']);
      
      switch ($type) {
        case 'global':
          $global_content[$id] = $content;
        break;
        case 'local-html':
          $local_html = $content;
        break;
        case 'local-javascript':
          $local_javascript = $content;
        break;
        case 'local-css':
          $local_css = $content;
        break;
        default:
          exit("Error: Unkonwn input parameters type...");
        break;
      }
      
      $main_page = $global_content[1];
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
//       $main_page = preg_replace('#\[GET_GLOBAL_PAGE:([0-9]+)\]#', $global_content[${1}], $main_page);
//       $main_page = preg_replace('#\[GET_GLOBAL_PAGE:2\]#', $global_content[2],$main_page);
      
      $main_page = preg_replace('#"images\/#', '"../images/', $main_page);
      $main_page = preg_replace('#\'images\/#', '\'../images/', $main_page);
      
      echo $main_page;
    }
    else {
      echo "Error: Wrong input parameters.\n";
    }
  }
  else {
    echo "Error: No input parameters.\n";
  }
?>