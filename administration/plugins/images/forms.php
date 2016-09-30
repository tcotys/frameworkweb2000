<script type="text/javascript">
 var listOfImgType = {'normal':'Normal', 'design':'Design général', 'cover':'Cover/texte Associé'};

  function showEditImgHelp() {
    var help_box = '';
    help_box += '<h2>Petit message d\'introduction à l\'upload d\'images :</h2>\n'
    help_box += '<ul>\n';
    help_box += '  <li>\n';
    help_box += '    L\'option de type d\'image n\'a pas de réelle incidence,\n';
    help_box += '    aide pour le rangement des images.\n';
    help_box += '  </li>\n';
    help_box += '  <li>\n';
    help_box += '    Idem pour le nom de l\'image, à ceci près que si l\'image n\'est pas chargée,\n';
    help_box += '    ce sera le nom de l\\\'image qui apparaitra à la place.\n';
    help_box += '  </li>\n';
    help_box += '</ul>\n';
    openDialogBox('editImgHelp', help_box);
  }
  function showEditImgForm(id, name, url, type) {
  var out_box = '';
    out_box += '<h2>Edition de l\'image : <em>'+name+'</em></h2>';
    out_box += '<p>\n';
    out_box += '  <a href=# onclick="showEditImgHelp(); return false;">Aide</a>\n';
    out_box += '</p>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/images/edit.php">\n';
    out_box += '    <label for="img_name">Nom de l\'image :</label>\n';
    out_box += '    <input type=text name="img_name" id="img_name" value="'+name+'" /><br />\n';
    out_box += '    <img src="../'+url+'" alt="'+name+'"/><br />\n';
    out_box += '    <label for="img_type">Type d\'image :</label>\n';
    out_box += '    <select name="img_type" id="img_type">\n';
    for (var key in listOfImgType) {
      out_box += '        <option value="'+key+'" ';
      if (type == key) {
        out_box += 'selected="selected" ';
      }
      out_box += '>'+listOfImgType[key]+'</option>\n';
    }
    out_box += '    </select><br />\n';
    out_box += '    <input type="hidden" name="id" value="'+id+'" />\n';
    out_box += '    <input type="submit" value="Editer l\'image" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    
    openDialogBox('editImgForm'+id, out_box);
    refreshScrollOnForms();
  }
  function deleteImg(img_id, nomFichier) {
    var params = {'img': img_id};
    var addr   = '<?php echo getBackPath(); ?>plugins/images/delete.php';
    var text   = 'l\'image : ' + nomFichier;
    askDelete(addr, params, text);
  }
  function getImgAdress(adress) {
    alert('Url de l\'image : ' + adress); }
  function getImgHtml(adress, name) {
    alert('<img src="' + adress + '" alt="' + name + '" />'); }
 function showNewImgForm() {
    var out_box = '';
    out_box += '<h2>Ajout d\'une nouvelle image</h2>\n';
    out_box += '<p>\n';
    out_box += '  <a href=# onclick="showNewImgHelp(); return false;">Aide</a>\n';
    out_box += '</p>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/images/new.php" enctype="multipart/form-data">\n';
    out_box += '    <label for="img_name">Nom de l\'image :</label>\n';
    out_box += '    <input type=text name="img_name" id="img_name" value="" /><br />\n';
    out_box += '    <label for="image_source">Image source :</label>\n';
    out_box += '    <input type="file" name="image_source" id="image_source" /><br />\n';
    out_box += '    <label for="out_folder">Dossier d\'arrivée de l\'image :</label>\n';
    out_box += '    <input type=text name="out_folder" id="out_folder" value="" />\n';
    out_box += '    <input type="checkbox" name="is_in_images" id="is_in_images" />\n';
    out_box += '    <label for="is_in_images">mettre de dossier dans le dossier "images"</label><br />\n';
    out_box += '    <label for="out_filename">Nom du fichier de l\'image :</label>\n';
    out_box += '    <input type=text name=out_filename id="out_filename" value="" />(sans extention)<br />\n';
    out_box += '    <label for="img_type">Type d\'image :</label>\n';
    out_box += '    <select name="img_type" id="img_type">\n';
    for (var key in listOfImgType) {
      out_box += '        <option value="'+key+'" >'+listOfImgType[key]+'</option>\n';
    }
    out_box += '    </select><br />\n';
    out_box += '    <input type=submit value="Ajouter l\\\'image" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('newImgForm', out_box);
    refreshScrollOnForms();
  }
  function showNewImgHelp() {
    var help_box = '';
    help_box += '<h2>Petit message d\\\'introduction à l\\\'upload d\\\'images :</h2>\n';
    help_box += '<ul>\n';
    help_box += '  <li>\n';
    help_box += '    Seul les caractères alphanumérique sont accepté, c\\\'est à dire a-z, A-Z, 0-9 et _(underscore).\n';
    help_box += '    Pas d\\\'espace ni d\\\'accent, afin d\\\'éviter des problèmes au niveau du serveur.\n';
    help_box += '  </li>\n';
    help_box += '  <li>\n';
    help_box += '    Si le nom de l\\\'image n\\\'est pas spécifié dans le champ prévu à cet effet,\n';
    help_box += '    le nom sera modifé de façon à ce qu\\\'il n\\\'y ait pas de doublon possible.\n';
    help_box += '  </li>\n';
    help_box += '  <li>\n';
    help_box += '    Si le dossier de destination n\\\'est pas spécifié non-plus,\n';
    help_box += '    l\\\'image sera déplacée dans le dossier "images/normal/".\n';
    help_box += '  </li>\n';
    help_box += '  <li>\n';
    help_box += '    L\\\'option de type d\\\'image n\\\'a pas de réelle incidence, mais aide pour le rangement des images.\n';
    help_box += '  </li>\n';
    help_box += '  <li>\n';
    help_box += '    Idem pour le nom de l\\\'image, à ceci près que si l\\\'image n\\\'est pas chargée,\n';
    help_box += '    ce sera le nom de l\\\'image qui apparaitra à la place.\n';
    help_box += '  </li>\n';
    help_box += '</ul>\n';
    openDialogBox('newImgHelp', help_box);
  }
</script>