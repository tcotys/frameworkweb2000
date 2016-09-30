<?php
  $local_pages = array(
    "name"             => "Notepad",
    "version"          => "20150716",
    "description"      => "Simple notepad",
    "list"             => "plugins/notes/menu.php",
    "list_type"        => "file",
    "menu"             => "Bloc Notes",
    "menu_type"        => "text",
    "section_id"       => "notes_article",
    "section_id_type"  => "text",
    "forms"            => "plugins/notes/infos/forms.php",
    "forms_type"       => "file",
    "buttons"          => "",
    "buttons_type"     => "none",
    "global_load"      => "",
    "global_load_type" => "none",
    "html_load"        => "",
    "html_load_type"   => "none",
    "css_load"         => "",
    "css_load_type"    => "none",
    "js_load"          => "",
    "js_load_type"     => "none",
    "files_dir"        => "",
    "files_dir_type"   => "none",
    "db_name"          => "notes",
    "db_name_type"     => "text",
    "db_create"        => 
      "  id int(11) NOT NULL AUTO_INCREMENT,\n".
      "  note_name varchar(40) COLLATE utf8_bin NOT NULL,\n".
      "  note_content text COLLATE utf8_bin NOT NULL,\n".
      "  PRIMARY KEY (id)\n".
      ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;\n\n",
    "db_create_type"   => "text",
    "web_script"       => "",
    "web_script_type"  => "none"
    );
 array_push($PluginsInfo, $local_pages); 
?>

