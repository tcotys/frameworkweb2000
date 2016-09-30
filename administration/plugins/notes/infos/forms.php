<script type="text/javascript">
  
  function showEditNoteInfoForm(id, note_name) {
    var out_box = '';
        out_box += '<h2>&Eacute;dition du nom de la note : '+note_name+'</h2>\n';
        out_box += '<p>\n';
        out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/notes/infos/edit.php">\n';
        out_box += '    Nom de la note : <input type=text name="note_name" value="'+note_name+'" /><br />\n';
        out_box += '    <input type=hidden name=id value="'+id+'" />\n';
        out_box += '    <input type=submit value="Enregistrer" />\n';
        out_box += '  </form>\n';
        out_box += '</p>\n';
    
    openDialogBox('editNoteForm'+id, out_box);
    refreshScrollOnForms();
  }
  
  function deleteNote(note_id, note_name) {
    var params = {'note':note_id};
    var addr   = '<?php echo getBackPath(); ?>plugins/notes/infos/delete.php';
    var text   = 'la note ' + note_name;
    askDelete(addr, params, text);
  }
  
  function showNewNoteForm() {
    var out_box = '';
    
    out_box += '<h2>Nouvelle note</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/notes/infos/new.php">\n';
    out_box += '    Nom de la note : <input type=text name="note_name" value="" /><br />\n';
    out_box += '    <input type=submit value="Creer" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('newPageForm', out_box);
    refreshScrollOnForms();
  }
  
</script>
