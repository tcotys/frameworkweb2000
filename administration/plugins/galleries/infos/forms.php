<script type="text/javascript"> 
  function showEditGalleryForm(id, name, author, mini_width, mini_height, large_width, large_height) {
    var out_box = '';
    out_box += '<h2>Edition de la gallerie '+name+'</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/galleries/infos/edit.php">\n';
    out_box += '    <label for="gal_name">Nom : <input type="text" name="name" id="gal_name" value="'+name+'" /></label><br />\n';
    out_box += '    <label for="gal_author">Auteur : <input type="text" name="author" id="gal_author" value="'+author+'" /></label><br />\n';
    out_box += '    <label for="gal_mini_width">Taille miniature (en px) :</label>\n';
    out_box += '       <input type="text" class="num_input" name="mini_width"  value="'+mini_width+'" id="gal_mini_width" />x\n';
    out_box += '       <input type="text" class="num_input" name="mini_height" value="'+mini_height+'" /><br />\n';
    out_box += '    <label for="gal_large_width">Taille large (en px) :</label>\n';
    out_box += '       <input type="text" class="num_input" name="large_width"  value="'+large_width+'" id="gal_large_width" />x\n';
    out_box += '       <input type="text" class="num_input" name="large_height" value="'+large_height+'" /><br />\n';
    out_box += '    <input type="hidden" name="gal_id" value="'+id+'" />\n';
    out_box += '    <input type=submit value="Edit" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('editGalleryForm'+id, out_box);
    refreshScrollOnForms();
  }
  function deleteGallery(redirection, nomFichier) {
    var params = {'id':redirection};
    var addr   = '<?php echo getBackPath(); ?>plugins/galleries/infos/delete.php';
    var text   = 'le document : ' + nomFichier
    askDelete(addr, params, text);
  }

  function showNewGalleryForm() {
    var out_box = '';
    out_box += '<h2>Création d\'une nouvelle gallerie</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/galleries/infos/new.php">\n';
    out_box += '    <label for="gal_name">Nom : <input type="text" name="name" id="gal_name" value="" /></label><br />\n';
    out_box += '    <label for="gal_author">Auteur : <input type="text" name="author" id="gal_author" value="" /></label><br />\n';
    out_box += '    <label for="gal_mini_width">Taille miniature (en px) :</label>\n';
    out_box += '       <input type="text" class="num_input" name="mini_width"  value="280" id="gal_mini_width" />x\n';
    out_box += '       <input type="text" class="num_input" name="mini_height" value="260" /><br />\n';
    out_box += '    <label for="gal_large_width">Taille large (en px) :</label>\n';
    out_box += '       <input type="text" class="num_input" name="large_width"  value="860" id="gal_large_width" />x\n';
    out_box += '       <input type="text" class="num_input" name="large_height" value="700" /><br />\n';
    out_box += '    <input type=submit value="Créer nouvelle page !" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('newGalleryForm', out_box);
    refreshScrollOnForms();
  }
</script>