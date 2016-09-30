<script>
  function showNewTracksForm() {
    var out_box = ''; 
    out_box += '<h2>Ajout de piste</h2>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/sounds/tracks/new.php" enctype="multipart/form-data">\n';
    out_box += '    <label for="sounds_tracks">Pistes audios :\n';
    out_box += '      <input type="file" name="tracks[]" id="tracks" multiple/></label><br />\n';
    out_box += '    <input type=submit value="Ajouter" />\n';
    out_box += '  </form>\n';
    openDialogBox('newTracksForm', out_box);
    refreshScrollOnForms();
  }
  function showEditTrackForm(id, name, author, cover_type) {
    out_box  = '<h2>Edition de la piste audio</h2>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/sounds/tracks/edit.php" enctype="multipart/form-data">\n';
    var accepted_cover_type = ["jpg", "png", "gif"];
    if(accepted_cover_type.indexOf(cover_type) != -1) {
      out_box += '  <img src="../sounds/'+id+'.'+cover_type+'" width="200px" /><br />\n';
    }
    out_box += '      <input type="hidden" name="track_id" value="'+id+'" />\n';
    out_box += '    <label for="track_name'+id+'">Titre de la piste :</label>\n';
    out_box += '      <input id="track_name'+id+'" type="text"   name="track_name" value="'+name+'" /><br />\n';
    out_box += '    <label for="track_author'+id+'">Auteur de la piste :</label>\n';
    out_box += '      <input id="track_author'+id+'" type="text"   name="track_author" value="'+author+'" /><br />\n';
    out_box += '    <label for="track_cover'+id+'">Pochette :\n';
    out_box += '      <input type="file" name="track_cover" id="track_cover'+id+'" /></label><br />\n';
    out_box += '        <input type="submit" value="Edit" />\n';
    out_box += '      </form>\n';
    openDialogBox('editTrackForm'+id, out_box);
    refreshScrollOnForms();
  }
  function deleteTrack(track_id) {
    var params = {'track_id' : track_id};
    var addr   = '<?php echo getBackPath(); ?>plugins/sounds/tracks/delete.php';
    var text   = 'la piste'
    askDelete(addr, params, text);
  }
</script>