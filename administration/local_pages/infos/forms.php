<script type="text/javascript"> 
//   var listOfMainPages = {0:'Aucune', 1:'Home', 2:'Music', 3:'Videos', 4:'Goodies', 5:'Contact'}; // kdarv
  var listOfMainPages = {0:'Aucune', 1:'Accueil', 2:'Line Up', 3:'Oldies', 4:'Contact'}; // tyrasonore
  
  function showEditPageInfoForm(id, page_name, url_titre, attached_to) {
    var out_box = '';
    out_box += '<h2>&Eacute;dition des informations de la page : '+page_name+'</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>local_pages/infos/edit.php">\n';
    out_box += '    Nom de la page : <input type=text name="page_name" value="'+page_name+'" /><br />\n';
    out_box += '    Url de l\'image du titre : <input type=text name="url_titre" value="'+url_titre+'" /><br />\n';
    out_box += '    Page attachée à :\n';
    out_box += '      <select name="attached_to">\n';
    for (var key in listOfMainPages) {
      out_box += '        <option value="'+key+'" ';
      if (attached_to == key) {
        out_box += 'selected="selected" ';
      }
      out_box += '>'+listOfMainPages[key]+'</option>\n';
    }
    out_box += '    </select><br />\n';
    out_box += '    <input type=hidden name=id value="'+id+'" />\n';
    out_box += '    <input type=submit value="Enregistrer" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    
    openDialogBox('editImgForm'+id, out_box);
    refreshScrollOnForms();
  }
  function deletePage(page_id, nomFichier) {
    var params = {'page':page_id};
    var addr   = '<?php echo getBackPath(); ?>local_pages/infos/delete.php';
    var text   = 'la page ' + nomFichier;
    askDelete(addr, params, text);
  }
  
  function getPageLink(adress) {
    alert('<a href="index.php?page=' + adress + '">Texte du lien</a>'); }
    

  function showNewPageForm() {
    var out_box = '';
    
    out_box += '<h2>Création d\'une nouvelle page</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>local_pages/infos/new.php">\n';
    out_box += '    Nom de la page : <input type=text name="page_name" value="" /><br />\n';
    out_box += '    Url de l\'image du titre : <input type=text name="url_titre" value="" /><br />\n';
    out_box += '    Page attachée à :\n';
    out_box += '    <select name="attached_to">\n';
    for (var key in listOfMainPages) {
      out_box += '      <option value="'+key+'" >'+listOfMainPages[key]+'</option>\n';
    }
    out_box += '    </select><br />\n';
    out_box += '    <input type=submit value="Créer nouvelle page !" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('newPageForm', out_box);
    refreshScrollOnForms();
  }
  
  // ----- Prévisualisation ----- //
  function generatePreview(textarea_id, page_id, page_type)
  {
    var out_txt = document.getElementById(textarea_id).value;
    var formElem        = document.createElement("form");
        formElem.method = "post";
        formElem.target = "preview";
        formElem.action = "<?php echo getBackPath(); ?>preview.php";
    var inp1Elem        = document.createElement("input");
        inp1Elem.type   = "hidden";
        inp1Elem.name   = "type";
        inp1Elem.value  = page_type;
        formElem.appendChild(inp1Elem);
    var inp2Elem        = document.createElement("input");
        inp2Elem.type   = "hidden";
        inp2Elem.name   = "page";
        inp2Elem.value  = page_id;
        formElem.appendChild(inp2Elem);
    var inp3Elem        = document.createElement("input");
        inp3Elem.type   = "hidden";
        inp3Elem.name   = "content";
        inp3Elem.value  = out_txt;
        formElem.appendChild(inp3Elem);
    
    document.body.appendChild(formElem);
        formElem.submit();
  }
</script>