<?php
//   if (file_exists("../../config.php")) {
//     require_once("../../config.php");
    $website_name = getSiteName();
    $website_path = getWebsitePath();
    $table_prefix = getTablePrefix();
    $db_host      = getDBhost();
    $db_name      = getDBname();
    $db_username  = getDBusername();
    $db_password  = getDBpassword();
//   }
//   else {
//     $website_name = "My website";
//     $website_path = "../";
//     $db_host      = "localhost";
//     $db_name      = "test";
//     $table_prefix = "newwebsite_";
//     $db_username  = "root";
//     $db_password  = "";
//   }
?>
<script>
  // ----- Formulaire en boite pour l'édition des fichiers ----- //
  function showEditMainParameters() {
    var out_txt = '    <h1>Website main settings</h1>'
                + '      <form method="post" action="website_manager/site_info/edit.php">'
                + '         <h3>General informations</h2>'
                + '         <p>'
                + '           <label for="website_name">Website name : </label>'
                + '           <input type="text" id="website_name" name="website_name" value="<?php echo $website_name; ?>" />'
                + '           <br />'
                + '           <label for="website_path">Website relative path : </label>'
                + '           <input type="text" id="website_path" name="website_path" value="<?php echo $website_path; ?>" />'
                + '         </p>'
                + '         <h3>Mysql database informations</h2>'
                + '         <p>'
                + '           <label for="db_host">Database host : </label>'
                + '           <input type="text" id="db_host" name="db_host" value="<?php echo $db_host; ?>" />'
                + '           <br />'
                + '           <label for="db_name">Database name : </label>'
                + '           <input type="text" id="db_name" name="db_name" value="<?php echo $db_name; ?>" />'
                + '           <br />'
                + '           <label for="db_host">Tables prefix : </label>'
                + '           <input type="text" id="table_prefix" name="table_prefix" value="<?php echo $table_prefix; ?>" />'
                + '           <br />'
                + '           <label for="db_username">Database User Name : </label>'
                + '           <input type="text" id="db_username" name="db_username" value="<?php echo $db_username; ?>" />'
                + '           <br />'
                + '           <label for="db_password">Database User Password : </label>'
                + '           <input type="text" id="db_password" name="db_password" value="<?php echo $db_password; ?>" />'
                + '           <br />'
                + '           <input type="submit" value="Save" />'
                + '         </p>'
                + '       </form>';
      
    openDialogBox('new_plugin_form', out_txt);
    refreshScrollOnForms();
  }
</script>
