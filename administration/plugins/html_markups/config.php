<?php
  $html_markups = array(
    "name"             => "Html markups",
    "version"          => "20150716",
    "description"      => "Help to add html markups in the editors",
    "list"             => "",
    "list_type"        => "none",
    "section_id"       => "",
    "section_id_type"  => "none",
    "menu"             => "",
    "menu_type"        => "none",
    "forms"            => "", 
    "forms_type"       => "none",
    "buttons"          => "plugins/html_markups/buttons.php",
    "buttons_type"     => "file",
    "global_load"      =>
      "addMarkupButtons(document.getElementById('menu_insert'), 'html_content_');\n".
      "addHtmlHelpButton(document.getElementById('menu_outils'));\n",
    "global_load_type" => "text",
    "html_load"        =>
      "addMarkupButtons(document.getElementById('menu_insert'), 'html_content_');\n".
      "addHtmlHelpButton(document.getElementById('menu_outils'));\n",
    "html_load_type"   => "text",
    "css_load"         => 
      "addHtmlHelpButton(document.getElementById('menu_outils'));\n",
    "css_load_type"    => "none",
    "js_load"          => 
      "addHtmlHelpButton(document.getElementById('menu_outils'));\n",
    "js_load_type"     => "none",
    "files_dir"        => "",
    "files_dir_type"   => "none",
    "db_name"          => "",
    "db_name_type"     => "none",
    "db_create"        => "",
    "db_create_type"   => "none",
    "web_script"       => "",
    "web_script_type"  => "none"
  );
 array_push($PluginsInfo, $html_markups); 
?>
