<script>
  // ----- Formulaire en boite pour l'édition des fichiers ----- //
  function editFileInfo(file_id, surname, filename) {
    var out_txt =           '<h2>Surnom du document "'+filename+'"</h2>\n';
        out_txt = out_txt + '<form action="<?php echo getBackPath(); ?>plugins/files/edit.php" method="post">\n';
        out_txt = out_txt + '  <input type="hidden" name="file_id"   value="'+file_id+'" />\n';
        out_txt = out_txt + '  <input type="text"   name="surname" value="'+surname+'" />\n';
        out_txt = out_txt + '  <input type="submit"                   value="Modifier" />\n';
        out_txt = out_txt + '</form>';
    openDialogBox('edit_file_info_'+file_id, out_txt);
    refreshScrollOnForms();
  }
  function deleteFile(file_id, nomFichier) {
    var params = {'file': file_id};
    var addr   = '<?php echo getBackPath(); ?>plugins/files/delete.php';
    var text   = 'le document : ' + nomFichier;
    askDelete(addr, params, text);
  }
  function getFileHtml(file_id,surname) {
    alert('<a href="download.php?file='+file_id+'&download=1">'+surname+'</a>');}
  function showNewFileForm() {
    var out_box = ''; 
    out_box += '<h2>Ajout d\'un nouveau document</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/files/new.php" enctype="multipart/form-data">\n';
    out_box += '    <label for="filename">Surnom du fichier :</label>\n';
    out_box += '      <input type=text name="surname" id="surname" value="" /><br />\n';
    out_box += '      <input type="file" name="file_source" id="file_source" /><br />\n';
    out_box += '    <input type=submit value="Upload" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('newFileForm', out_box);
    refreshScrollOnForms();
  }
</script>