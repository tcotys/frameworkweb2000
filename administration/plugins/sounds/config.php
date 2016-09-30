<?php
  $galleries = array(
    "name"             => "Sound/Playlists manager",
    "version"          => "20150716",
    "description"      => "Simple audio and playlist manager.",
    "list"             => "plugins/sounds/menu.php",
    "list_type"        => "file",
    "menu"             => array("Audio : Playlists", "Audio : Pistes"),
    "menu_type"        => "texts",
    "section_id"       => array("sounds_playlists_article", "sounds_tracks_article"),
    "section_id_type"  => "texts",
    "forms"            => array("plugins/sounds/playlists/forms.php", "plugins/sounds/tracks/forms.php"), 
    "forms_type"       => "files",
    "buttons"          => "plugins/sounds/buttons.php",
    "buttons_type"     => "file",
    "global_load"      => "addHtmlPlaylistButton(document.getElementById('menu_insert'), 'html_content_');\n",
    "global_load_type" => "text",
    "html_load"        => "addHtmlPlaylistButton(document.getElementById('menu_insert'), 'html_content_');\n",
    "html_load_type"   => "text",
    "css_load"         => "",
    "css_load_type"    => "none",
    "js_load"          => "",
    "js_load_type"     => "none",
    "files_dir"        => "sounds/",
    "files_dir_type"   => "text",
    "db_name"          => array("sounds_playlists", "sounds_tracks"),
    "db_name_type"     => "texts",
    "db_create"        => array(
      "  id        int(11)      NOT NULL AUTO_INCREMENT,\n".
      "  name      varchar(120) NOT NULL,\n".
      "  style     varchar(80)  NOT NULL,\n".
      "  tracks    varchar(80)  NOT NULL,\n".
      "  PRIMARY KEY (id)\n".
      ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;\n\n",
      
      "  id          int(11)      NOT NULL AUTO_INCREMENT,\n".
      "  name        varchar(80)  NOT NULL,\n".
      "  author      varchar(80)  NOT NULL,\n".
      "  type        varchar(40)  NOT NULL,\n".
      "  source      varchar(120) NOT NULL,\n".
      "  cover_type  varchar(80)  NOT NULL,\n".
      "  PRIMARY KEY (id)\n".
      ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;\n\n"),
    "db_create_type"   => "texts",
    "web_script"       => array("plugins/sounds/scripts/playlist-plugin.js","plugins/sounds/scripts/playlist-plugin.css"),
    "web_script_type"  => "files"
  );
 array_push($PluginsInfo, $galleries); 
?>

