<?php
  $local_pages = array(
    "name"             => "Dynamic pages",
    "version"          => "20150716",
    "description"      => "Dynamic local pages : html, css, javascript",
    "list"             => "local_pages/menu.php",
    "list_type"        => "file",
    "menu"             => "Pages locales",
    "menu_type"        => "text",
    "section_id"       => "local_pages_article",
    "section_id_type"  => "text",
    "forms"            => "local_pages/infos/forms.php",
    "forms_type"       => "file",
    "buttons"          => "local_pages/buttons.php",
    "buttons_type"     => "file",
    "global_load"      => 
      "addHtmlLinkButton(document.getElementById('menu_insert'), 'html_content_');\n".
      "addJsLinkButton(document.getElementById('menu_insert_script'), 'html_content_');\n".
      "addOldLocalPagesButton(document.getElementById('menu_outils'));\n",
    "global_load_type" => "text",
    "html_load"        => 
      "addHtmlLinkButton(document.getElementById('menu_insert'), 'html_content_');\n".
      "addOldLocalPagesButton(document.getElementById('menu_outils'));\n",
    "html_load_type"   => "text",
    "css_load"         => 
      "addOldLocalPagesButton(document.getElementById('menu_outils'));\n",
    "css_load_type"    => "text",
    "js_load"          => 
      "addJsLinkButton(document.getElementById('menu_insert'), 'javascript_content_');\n".
      "addOldLocalPagesButton(document.getElementById('menu_outils'));\n",
    "js_load_type"     => "text",
    "files_dir"        => "",
    "files_dir_type"   => "none",
    "db_name"          => "pages",
    "db_name_type"     => "text",
    "db_create"        => 
      "  id int(11) NOT NULL AUTO_INCREMENT,\n".
      "  page_name varchar(40) COLLATE utf8_bin NOT NULL,\n".
      "  url_titre varchar(60) COLLATE utf8_bin NOT NULL,\n".
      "  attached_to int(11) NOT NULL,\n".
      "  html_content text COLLATE utf8_bin NOT NULL,\n".
      "  css_content text COLLATE utf8_bin NOT NULL,\n".
      "  javascript_content text COLLATE utf8_bin NOT NULL,\n".
      "  PRIMARY KEY (id)\n".
      ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;\n\n",
    "db_create_type"   => "text",
    "web_script"       => "",
    "web_script_type"  => "none"
    );
 array_push($PluginsInfo, $local_pages); 
?>
    
