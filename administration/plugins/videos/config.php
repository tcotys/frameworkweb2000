<?php
  $videos = array(
    "name"             => "Videos",
    "version"          => "20150716",
    "description"      => "Handle both local and youtube videos",
    "menu"           => "Vidéos",
    "menu_type"      => "text",
    "section_id"       => "videos_article",
    "section_id_type"  => "text",
    "list"           => "plugins/videos/menu.php",
    "list_type"      => "file",
    "forms"          => "plugins/videos/forms.php",
    "forms_type"     => "file",
    "buttons"        => "plugins/videos/buttons.php",
    "buttons_type"   => "file",
    "global_load"      => "addHtmlVideoButton(document.getElementById('menu_insert'), 'html_content_');\n",
    "global_load_type" => "text",
    "html_load"        => "addHtmlVideoButton(document.getElementById('menu_insert'), 'html_content_');\n",
    "html_load_type"   => "text",
    "css_load"         => "",
    "css_load_type"    => "none",
    "js_load"          => "",
    "js_load_type"     => "none",
    "files_dir"      => "videos/",
    "files_dir_type" => "text",
    "db_name"        => "videos",
    "db_name_type"   => "text",
    "db_create"      => 
      "  id     int(11) NOT NULL AUTO_INCREMENT,\n".
      "  name   varchar(80) COLLATE utf8_bin NOT NULL,\n".
      "  width  int(11) NOT NULL,\n".
      "  height int(11) NOT NULL,\n".
      "  type   varchar(20) COLLATE utf8_bin NOT NULL,\n".
      "  source text COLLATE utf8_bin NOT NULL,\n".
      "  PRIMARY KEY (`id`)\n".
      ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;\n\n",
    "db_create_type" => "text",
    "web_script"       => array("plugins/videos/scripts/videos-plugin.js","plugins/videos/scripts/videos-plugin.css"),
    "web_script_type"  => "files"
  );
  array_push($PluginsInfo, $videos); 
?>
