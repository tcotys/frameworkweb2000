<?php
  $galleries = array(
    "name"             => "Pictures Galleries",
    "version"          => "20150716",
    "description"      => "Generic picture galleries managers",
    "list"             => "plugins/galleries/menu.php",
    "list_type"        => "file",
    "menu"             => "Galleries",
    "menu_type"        => "text",
    "section_id"       => "galleries_article",
    "section_id_type"  => "text",
    "forms"            => array("plugins/galleries/infos/forms.php", "plugins/galleries/images/forms.php"), 
    "forms_type"       => "files",
    "buttons"          => "plugins/galleries/buttons.php",
    "buttons_type"     => "file",
    "global_load"      => "addHtmlGalleryButton(document.getElementById('menu_insert'), 'html_content_');\n",
    "global_load_type" => "text",
    "html_load"        => "addHtmlGalleryButton(document.getElementById('menu_insert'), 'html_content_');\n",
    "html_load_type"   => "text",
    "css_load"         => "",
    "css_load_type"    => "none",
    "js_load"          => "",
    "js_load_type"     => "none",
    "files_dir"        => "files/",
    "files_dir_type"   => "text",
    "files_dir"        => "galleries/",
    "files_dir_type"   => "text",
    "db_name"          => "galleries",
    "db_name_type"     => "text",
    "db_create"        => 
      "  id           int(11)     NOT NULL AUTO_INCREMENT,\n".
      "  name         varchar(80) NOT NULL,\n".
      "  author       varchar(80) NOT NULL,\n".
      "  mini_width   int(11)     NOT NULL,\n".
      "  mini_height  int(11)     NOT NULL,\n".
      "  large_width  int(11)     NOT NULL,\n".
      "  large_height int(11)     NOT NULL,\n".
      "  nb_img       int(11)     NOT NULL,\n".
      "  PRIMARY KEY (id)\n".
      ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;\n\n",
    "db_create_type"   => "text",
    "web_script"       => array("plugins/galleries/scripts/shortcut.js",
                                "plugins/galleries/scripts/basic_functions.js",
                                "plugins/galleries/scripts/galleries-plugin.js",
                                "plugins/galleries/scripts/galleries-plugin.css"),
    "web_script_type"  => "files"
  );
 array_push($PluginsInfo, $galleries); 
?>

