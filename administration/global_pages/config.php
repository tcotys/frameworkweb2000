<?php
  $global_pages = array(
    "name"             => "Static global pages",
    "version"          => "20150716",
    "description"      => "Static global pages",
    "list"             => "global_pages/menu.php",
    "list_type"        => "file",
    "menu"             => "Pages globales",
    "menu_type"        => "text",
    "section_id"       => "global_pages_article",
    "section_id_type"  => "text",
    "forms"            => "global_pages/infos/forms.php",
    "forms_type"       => "file",
    "buttons"          => "global_pages/buttons.php",
    "buttons_type"     => "file",
    "global_load"      => 
      "addHtmlGlobalPageButton(document.getElementById('menu_insert_script'), 'html_content_');\n".
      "addOldGlobalPagesButton(document.getElementById('menu_outils'));\n",
    "global_load_type" => "text",
    "html_load"        => 
      "addHtmlGlobalPageButton(document.getElementById('menu_insert'), 'html_content_');\n".
      "addOldGlobalPagesButton(document.getElementById('menu_outils'));\n",
    "html_load_type"   => "text",
    "css_load"         => 
      "addHtmlGlobalPageButton(document.getElementById('menu_insert'), 'css_content_');\n".
      "addOldGlobalPagesButton(document.getElementById('menu_outils'));\n",
    "css_load_type"    => "text",
    "js_load"          => 
      "addHtmlGlobalPageButton(document.getElementById('menu_insert'), 'javascript_content_');\n".
      "addOldGlobalPagesButton(document.getElementById('menu_outils'));\n",
    "js_load_type"     => "text",
    "files_dir"        => "",
    "files_dir_type"   => "none",
    "db_name"          => 'info',
    "db_name_type"     => "text",
    "db_create"        => 
      "  id int(11) NOT NULL AUTO_INCREMENT,\n".
      "  name varchar(20) COLLATE utf8_bin NOT NULL,\n".
      "  content text COLLATE utf8_bin NOT NULL,\n".
      "  PRIMARY KEY (id)\n".
      ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;\n\n",
    "db_create_type"   => "text",
    "web_script"       => array("global_pages/scripts/index.html", "global_pages/scripts/style.css"),
    "web_script_type"  => "files"
  );
 array_push($PluginsInfo, $global_pages); 
?>
    
