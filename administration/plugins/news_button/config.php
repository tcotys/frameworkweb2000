<?php
  $news_tyra = array(
    "name"             => "News generator",
    "version"          => "20150716",
    "description"      => "Help to add the news in local/global pages",
    "list"             => "",
    "list_type"        => "none",
    "section_id"       => "",
    "section_id_type"  => "none",
    "menu"             => "",
    "menu_type"        => "none",
    "forms"            => "", 
    "forms_type"       => "none",
    "buttons"          => "plugins/news_tyra/buttons.php",
    "buttons_type"     => "file",
    "global_load"      => "addHtmlNewsButton(document.getElementById('menu_insert'), 'html_content_');\n",
    "global_load_type" => "text",
    "html_load"        => "addHtmlNewsButton(document.getElementById('menu_insert'), 'html_content_');\n",
    "html_load_type"   => "text",
    "css_load"         => "",
    "css_load_type"    => "none",
    "js_load"          => "",
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
  array_push($PluginsInfo, $news_tyra); 
?>
