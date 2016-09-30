<?php
  $files = array(
    "name"             => "Files",
    "version"          => "20150716",
    "description"      => "Generic files manager",
    "list"             => "plugins/files/menu.php",
    "list_type"        => "file",
    "menu"             => "Fichiers",
    "menu_type"        => "text",
    "section_id"       => "files_article",
    "section_id_type"  => "text",
    "forms"            => "plugins/files/forms.php",
    "forms_type"       => "file",
    "buttons"          => "plugins/files/buttons.php",
    "buttons_type"     => "file",
    "global_load"      => 
      "addHtmlFileButton(document.getElementById('menu_insert'), 'html_content_');\n".
      "addJsFileButton(document.getElementById('menu_insert_script'), 'html_content_');\n".
      "addOldFilesButton(document.getElementById('menu_outils'));\n",
    "global_load_type" => "text",
    "html_load"        =>
      "addHtmlFileButton(document.getElementById('menu_insert'), 'html_content_');\n".
      "addOldFilesButton(document.getElementById('menu_outils'));\n",
    "html_load_type"   => "text",
    "css_load"         =>
      "addCssFileButton(document.getElementById('menu_insert'), 'css_content_');\n".
      "addOldFilesButton(document.getElementById('menu_outils'));\n",
    "css_load_type"    => "text",
    "js_load"          =>
      "addJsFileButton(document.getElementById('menu_insert'), 'javascript_content_');\n".
      "addOldImagesButton(document.getElementById('menu_outils'));\n",
    "js_load_type"     => "text",
    "files_dir"        => "files/",
    "files_dir_type"   => "text",
    "db_name"          => "files",
    "db_name_type"     => "text",
    "db_create"        => 
      "  id int(11) NOT NULL AUTO_INCREMENT,\n".
      "  surname varchar(80) COLLATE utf8_bin NOT NULL,\n".
      "  filename varchar(80) COLLATE utf8_bin NOT NULL,\n".
      "  filetype varchar(10) COLLATE utf8_bin NOT NULL,\n".
      "  url varchar(80) COLLATE utf8_bin NOT NULL,\n".
      "  PRIMARY KEY (id)\n".
      ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;\n\n",
    "db_create_type" => "text",
    "web_script"       => "",
    "web_script_type"  => "none");
 array_push($PluginsInfo, $files); 
?>
    
