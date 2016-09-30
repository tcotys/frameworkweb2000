<script>
  // ----- Formulaire en boite pour l'édition des fichiers ----- //
  function showNewPluginUpload() {
    var out_txt = ''
                + '<h2>New plugin upload</h2>\n'
                + '<p>\n'
                + '  <form method=post action="<?php echo getBackPath(); ?>website_manager/mysql_tables/new.php" enctype="multipart/form-data">\n'
                + '      <input type="file" name="file_source" id="file_source" /><br />\n'
                + '    <input type=submit value="Load" />\n'
                + '  </form>\n'
                + '</p>\n'
    openDialogBox('new_plugin_form', out_txt);
    refreshScrollOnForms();
  }
</script>