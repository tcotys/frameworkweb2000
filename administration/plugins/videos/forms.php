<script type="text/javascript">
  function showEditVideoForm(id, name, width, height, type, source) {
    var youtube_url = "Url de la video";
    if(type == "youtube")  {
      youtube_url = source;
    }
    var out_box = '';
    out_box += '<h2>Edition de la vidéo:'+name+'</h2>\n';
    out_box += '<form method=post action="<?php echo getBackPath(); ?>plugins/videos/edit.php" enctype="multipart/form-data">\n';
    out_box += '  <input type="hidden" name="vid_id" value="'+id+'" /><br />\n';
    out_box += '  <label for="vid_name">Nom de la vidéo :</label><input type=text name="vid_name" id="vid_name" value="'+name+'" /><br />\n';
    out_box += '  <label for="vid_poster">Screenshot de la vidéo :</label><input type="file" id="vid_poster" name="vid_poster" /><br />\n';
    out_box += '  <label for="vid_width">Taille de la vidéo :</label>\n';
    out_box += '  <input type="text" id="vid_width" class="vid_size" name="vid_width" value="'+width+'" />px ';
    out_box += '    X<input type="text" class="vid_size" name="vid_height" value="'+height+'" />px<br />\n';
    out_box += '  Type de vidéo :<br />\n';
    out_box += '  <label for="youtube_vid"><input type="radio" id="youtube_vid"';
    if(type == "youtube") {out_box += ' checked="checked""';}
    out_box += ' name="vid_type" value="youtube" />\n';
    out_box += '    Youtube <input type="text" name="youtube_url" value="'+youtube_url+'" /></label><br />\n';
    out_box += '  <label for="local_vid"><input type="radio" id="local_vid"';
    if(type == "local") {out_box += ' checked="checked"';}
    out_box += ' name="vid_type"value="local" />Upload sur le serveur<br />\n';
    out_box += '  <label class="vid_local" for="vid_sourceMP4" >Format MP4  :</label><input type="file" name="vid_sourceMP4"  id="vid_sourceMP4"  /><br />\n';
    out_box += '  <label class="vid_local" for="vid_sourceWEBM">Format WEBM :</label><input type="file" name="vid_sourceWEBM" id="vid_sourceWEBM" /><br />\n';
    out_box += '  <label class="vid_local" for="vid_sourceOGV" >Format OGV  :</label><input type="file" name="vid_sourceOGV"  id="vid_sourceOGV"  /><br />\n';
    out_box += '  <input type=submit value="Modifier" />\n';
    out_box += '</form>\n';
    openDialogBox('editVideoForm'+id, out_box);
    refreshScrollOnForms();
  }
  function deleteVideo(video_id, nomFichier) {
    var params = {'video': video_id};
    var addr   = '<?php echo getBackPath(); ?>plugins/videos/delete.php';
    var text   = 'la vidéo : ' + nomFichier;
    askDelete(addr, params, text);
  }
  function showNewVideoForm() {
    var out_box = '';
    out_box += '<h2>Ajout d\'une nouvelle vidéo</h2>\n';
    out_box += '<form method=post action="<?php echo getBackPath(); ?>plugins/videos/new.php" enctype="multipart/form-data">\n';
    out_box += '  <label for="vid_name">Nom de la vidéo :</label><input type=text name="vid_name" id="vid_name" value="" /><br />\n';
    out_box += '  <label for="vid_poster">Screenshot de la vidéo :</label><input type="file" id="vid_poster" name="vid_poster" /><br />\n';
    out_box += '  <label for="vid_width">Taille de la vidéo :</label>\n';
    out_box += '  <input type="text" id="vid_width" class="vid_size" name="vid_width" value="640" />px ';
    out_box += '    X<input type="text" class="vid_size" name="vid_height" value="360" />px<br />\n';
    out_box += '  Type de vidéo :<br />\n';
    out_box += '  <label for="youtube_vid"><input type="radio" id="youtube_vid" name="vid_type" value="youtube" /> Youtube <input type="text" name="youtube_url" value="Url de la video" /></label><br />\n';
    out_box += '  <label for="local_vid"><input type="radio" id="local_vid" name="vid_type" value="local" />Upload sur le serveur<br />\n';
    out_box += '  <label class="vid_local" for="vid_sourceMP4" >Format MP4  :</label><input type="file" name="vid_sourceMP4"  id="vid_sourceMP4"  /><br />\n';
    out_box += '  <label class="vid_local" for="vid_sourceWEBM">Format WEBM :</label><input type="file" name="vid_sourceWEBM" id="vid_sourceWEBM" /><br />\n';
    out_box += '  <label class="vid_local" for="vid_sourceOGV" >Format OGV  :</label><input type="file" name="vid_sourceOGV"  id="vid_sourceOGV"  /><br />\n';
    out_box += '  <input type=submit value="Ajouter" />\n';
    out_box += '</form>\n';
    openDialogBox('newVideoForm', out_box);
    refreshScrollOnForms();
  }
</script>