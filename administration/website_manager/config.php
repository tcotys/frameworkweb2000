<?php
  $website_manager_config = array(
    "name"             => "Website manager",
    "version"          => "20150716",
    "description"      => "Manage the website install and the plugins",
    "list"             => "website_manager/menu.php",
    "list_type"        => "file",
    "menu"             => "Website Manager",
    "menu_type"        => "text",
    "section_id"       => "website_manager_article",
    "section_id_type"  => "text",
    "forms"            => array("website_manager/site_info/forms.php", 'website_manager/mysql_tables/forms.php'),
    "forms_type"       => "files",
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
    "db_name"          => "",
    "db_name_type"     => "none",
    "db_create"        => "",
    "db_create_type"   => "none",
    "web_script"       => "",
    "web_script_type"  => "none"
    
    );
 array_push($PluginsInfo, $website_manager_config); 
?>
    
