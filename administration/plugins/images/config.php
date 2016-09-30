<?php
  $images = array(
    "name"             => "Images",
    "version"          => "20150716",
    "description"      => "Basic image manager",
    "list"             => "plugins/images/menu.php",
    "list_type"        => "file",
    "menu"             => "Images",
    "menu_type"        => "text",
    "section_id"       => "images_article",
    "section_id_type"  => "text",
    "forms"            => "plugins/images/forms.php",
    "forms_type"       => "file",
    "buttons"          => "plugins/images/buttons.php",
    "buttons_type"     => "file",
    "global_load"      =>
      "addHtmlImageButton(document.getElementById('menu_insert'), 'html_content_');\n".
      "addJsImageButton(document.getElementById('menu_insert_script'), 'html_content_');\n".
      "addOldImagesButton(document.getElementById('menu_outils'));\n",
    "global_load_type" => "text",
    "html_load"        =>
      "addHtmlImageButton(document.getElementById('menu_insert'), 'html_content_');\n".
      "addOldImagesButton(document.getElementById('menu_outils'));\n",
    "html_load_type"   => "text",
    "css_load"         =>
      "addCssImageButton(document.getElementById('menu_insert'), 'css_content_');\n".
      "addOldImagesButton(document.getElementById('menu_outils'));\n",
    "css_load_type"    => "text",
    "js_load"          =>
      "addJsImageButton(document.getElementById('menu_insert'), 'javascript_content_');\n".
      "addOldImagesButton(document.getElementById('menu_outils'));\n",
    "js_load_type"     => "text",
    "files_dir"        => "images/",
    "files_dir_type"   => "text",
    "db_name"          => "img",
    "db_name_type"     => "text",
    "db_create"        => 
      "  id int(11) NOT NULL AUTO_INCREMENT,\n".
      "  name varchar(40) COLLATE utf8_bin NOT NULL,\n".
      "  type varchar(40) COLLATE utf8_bin NOT NULL,\n".
      "  url varchar(80) COLLATE utf8_bin NOT NULL,\n".
      "  PRIMARY KEY (id)\n".
      ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;\n\n",
    "db_create_type" => "text",
    "web_script"       => "",
    "web_script_type"  => "none"
  );
 array_push($PluginsInfo, $images); 
?>
