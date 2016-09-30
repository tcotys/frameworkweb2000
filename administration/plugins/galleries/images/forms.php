<script>
  function showEditGalleryImagesForm(id, name, author, nb_img) {
    out_box  = '<h2>Edition de la gallerie d\'images : <strong>'+name+'</strong> par <em>'+author+'</em></h2>\n';
    out_box += '<ul class="edit_gal_img_list">\n';
    var it1, it2;
    for(it1 = 1; it1<=nb_img;it1++) {
      out_box += '<li>\n';
      out_box += '  '+it1+'.\n';
      out_box += '  <img src="../galleries/'+id+'/mini/'+it1+'.jpg" />\n';
      out_box += '  <ul>\n';
      out_box += '    <li>\n';
      out_box += '      <form method="post" action="<?php echo getBackPath(); ?>plugins/galleries/images/edit.php">\n';
      out_box += '        <select name="new_id">\n';
      for(it2 = 1; it2<= nb_img; it2++) {
        if(it1 != it2) {
          out_box += '          <option value="'+it2+'">Before '+it2+'</option>\n';
        }
      }
      out_box += '          <option value="end">End</option>\n';
      out_box += '        <input type="hidden" name="old_id" value="'+it1+'" />\n';
      out_box += '        <input type="hidden" name="gal_id" value="'+id+'" />\n';
      out_box += '        <input type="hidden" name="nb_img" value="'+nb_img+'" />\n';
      out_box += '        <input type="submit" value="Move" />\n';
      out_box += '      </form>\n';
      out_box += '    <li><a href="#" onclick="deleteGalleryImage('+id+', '+it1+'); return false;">Delete</a></li>\n';
      out_box += '  </ul>\n';
      out_box += '</li>';
    }
    out_box += '</ul>';
    openDialogBox('editGalleryImagesForm'+id, out_box);
    refreshScrollOnForms();
  }
  function deleteGalleryImage(gal_id, img_id) {
    var params = {'gal_id' : gal_id, 'img_id' : img_id};
    var addr   = '<?php echo getBackPath(); ?>plugins/galleries/images/delete.php';
    var text   = 'l\'image'
    askDelete(addr, params, text);
  }
  
  function showNewGalleryImagesForm(gal_id, name) {
    var out_box = ''; 
    out_box += '<h2>Ajout d\'images dans la gallerie "'+name+'"</h2>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/galleries/images/new.php" enctype="multipart/form-data">\n';
    out_box += '    <label for="images">Images :\n';
    out_box += '      <input type="file" name="images[]" id="images" multiple/></label><br />\n';
    out_box += '    <input type="hidden" name="gal_id" value="'+gal_id+'" />\n';
    out_box += '    <input type=submit value="Ajouter" />\n';
    out_box += '  </form>\n';
    openDialogBox('newFileForm', out_box);
    refreshScrollOnForms();
  }
</script>
<style>
  .edit_gal_img_list li {
    display:inline-block;
    width:220px;
    height:220px;
  }
  .edit_gal_img_list li img {
    max-width:200px;
    max-height:120px;
  }
  .edit_gal_img_list li ul {
    padding:0px;
  }
  .edit_gal_img_list li ul li {
    display:list-item;
    list-style-type: none;
    list-style-position: inside;
    width:auto;
    height:auto;
/*     margin-left:5px; */
  }
</style> 