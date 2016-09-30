<script type="text/javascript">
  function showDatabaseUploadForm() {
    var out_box = '';
    
    out_box += '<h2>Chargement d\'un fichier de backup</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>backups/upload.php" enctype="multipart/form-data">\n';
    out_box += '    <label for="filename">Surnom du fichier :</label>\n';
    out_box += '      <input type="file" name="file_source" id="file_source" /><br />\n';
    out_box += '      <input type="hidden" name="MAX_FILE_SIZE" value="'+(1048576*200)+'" />\n';
    out_box += '    <input type=submit value="Upload" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('databaseUploadForm', out_box);
    refreshScrollOnForms();
  }
  function deleteBackup(filename) {
    var params = {'file': filename};
    var addr   = '<?php echo getBackPath(); ?>backups/delete.php';
    var text   = 'le backup : ' + filename;
    askDelete(addr, params, text);
    return false;
  }
</script>