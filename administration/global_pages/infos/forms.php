<script>
  // ----- Edit Info on dialogBox----- //
  function editGlobalPageInfo(gpage_id, gpage_name) {
    var out_txt =           '<h2>Changer le nom d\'une page globale</h2>\n';
        out_txt = out_txt + '<form action="<?php echo getBackPath(); ?>global_pages/infos/edit.php" method="post">\n';
        out_txt = out_txt + '  <input type="hidden" name="gpage_id"   value="'+gpage_id+'" />\n';
        out_txt = out_txt + '  <input type="text"   name="gpage_name" value="'+gpage_name+'" />\n';
        out_txt = out_txt + '  <input type="submit"                   value="Enregistrer" />\n';
        out_txt = out_txt + '</form>';
    openDialogBox('edit_global_page_info_'+gpage_id, out_txt);
    refreshScrollOnForms();
  }
  function deleteGlobalPage(page_id, nomFichier) {
    var params = {'page': page_id};
    var addr   = '<?php echo getBackPath(); ?>global_pages/infos/delete.php';
    var text   = 'la page globale ' + nomFichier;
    askDelete(addr, params, text);
  }
  
  function showNewGlobalPageForm() {
    var out_box = '';
    out_box += '<h2>Création d\'une nouvelle page globale</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>global_pages/infos/new.php">\n';
    out_box += '    Nom de la page : <input type=text name="page_name" value="" /><br />\n';
    out_box += '    <input type=submit value="Créer nouvelle page !" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('newGlobalPageForm', out_box);
    refreshScrollOnForms();
  }
</script>