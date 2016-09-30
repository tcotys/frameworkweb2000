<script>
function addHtmlFileButton(elem, textarea_prefix)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Fichier";
  list_a.href = "#";
  var list_ul = document.createElement('ul');
  <?php   
    $rep8 = $bdd->query('SELECT * FROM '.getTablePrefix().'files');
    while ($don8 = $rep8->fetch()){
      ?>
        var button_elem = document.createElement('a');
            button_elem.href = "#";
            button_elem.innerHTML =  "<?php echo $don8['surname'].' ('.$don8['filename'].')'; ?>";
            button_elem.setAttribute("data-id", "<?php echo $don8['id']; ?>");
            button_elem.setAttribute("data-surname", "<?php echo $don8['surname']; ?>");
            button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
            button_elem.onclick = addFileInHtmlCode;
        var li_elem = document.createElement('li');
        li_elem.appendChild(button_elem);
        list_ul.appendChild(li_elem);
      <?php
    }
    $rep8->closeCursor();
  ?>
  
  
  list_li.appendChild(list_a);
  list_li.appendChild(list_ul);
  elem.appendChild(list_li);
}
function addCssFileButton(elem, textarea_prefix)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Fichier";
  list_a.href = "#";
  var list_ul = document.createElement('ul');
  <?php   
    $rep8 = $bdd->query('SELECT * FROM '.getTablePrefix().'files');
    while ($don8 = $rep8->fetch()){
      ?>
        var button_elem = document.createElement('a');
            button_elem.href = "#";
            button_elem.innerHTML =  "<?php echo $don8['surname'].' ('.$don8['filename'].')'; ?>";
            button_elem.setAttribute("data-id", "<?php echo $don8['id']; ?>");
            button_elem.setAttribute("data-surname", "<?php echo $don8['surname']; ?>");
            button_elem.setAttribute("data-filename", "<?php echo $don8['filename']; ?>");
            button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
            button_elem.onclick = addFileInCssCode;
        var li_elem = document.createElement('li');
        li_elem.appendChild(button_elem);
        list_ul.appendChild(li_elem);
      <?php
    }
    $rep8->closeCursor();
  ?>
  
  
  list_li.appendChild(list_a);
  list_li.appendChild(list_ul);
  elem.appendChild(list_li);
}
function addJsFileButton(elem, textarea_prefix)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Fichier";
  list_a.href = "#";
  var list_ul = document.createElement('ul');
  <?php   
    $rep8 = $bdd->query('SELECT * FROM '.getTablePrefix().'files');
    while ($don8 = $rep8->fetch()){
      ?>
        var button_elem = document.createElement('a');
            button_elem.href = "#";
            button_elem.innerHTML =  "<?php echo $don8['surname'].' ('.$don8['filename'].')'; ?>";
            button_elem.setAttribute("data-id", "<?php echo $don8['id']; ?>");
            button_elem.setAttribute("data-surname", "<?php echo $don8['surname']; ?>");
            button_elem.setAttribute("data-filename", "<?php echo $don8['filename']; ?>");
            button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
            button_elem.onclick = addFileInCssCode;
        var li_elem = document.createElement('li');
        li_elem.appendChild(button_elem);
        list_ul.appendChild(li_elem);
      <?php
    }
    $rep8->closeCursor();
  ?>
  
  
  list_li.appendChild(list_a);
  list_li.appendChild(list_ul);
  elem.appendChild(list_li);
}

function addFileInHtmlCode(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var id      = target.getAttribute("data-id");
  var surname = target.getAttribute("data-surname");
  var init_markup  = '<a href="download.php?file='+id+'&download=1">'+surname+'</a>';
  var textarea_prefix = target.getAttribute("data-textarea-prefix");
  var end_marlup = '';
  addMarkup(init_markup, end_marlup, textarea_prefix);
  return false;
}
function addFileInCssCode(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var id      = target.getAttribute("data-id");
  var surname = target.getAttribute("data-surname");
  var filename = target.getAttribute("data-filename");
  var init_markup  = 'url("'+filename+'")';
  var textarea_prefix = target.getAttribute("data-textarea-prefix");
  var end_marlup = '';
  addMarkup(init_markup, end_marlup, textarea_prefix);
  return false;
}
function addFileInJsCode(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var id      = target.getAttribute("data-id");
  var surname = target.getAttribute("data-surname");
  var filename = target.getAttribute("data-filename");
  var init_markup  = '"'+filename+'"';
  var textarea_prefix = target.getAttribute("data-textarea-prefix");
  var end_marlup = '';
  addMarkup(init_markup, end_marlup, textarea_prefix);
  return false;
}

// ----- Old deprecated stuffs ----- //µ
function addOldFilesButton(elem)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Files";
  list_a.href = "#";
  list_a.onclick = showFilesList;
  list_li.appendChild(list_a);
  elem.appendChild(list_li);
}

function showFilesList() {
  out_txt  = '';
  out_txt += '<h2>Outils d\'affichage de documents</h2>';
  out_txt += '  <ul>';
    <?php   
      $rep8 = $bdd->query('SELECT * FROM '.getTablePrefix().'files');
      while ($don8 = $rep8->fetch()){
        echo '
          out_txt += \'<li><em style="display:inline-block;width:400px;" >'.addslashes($don8['surname']).'("'.addslashes($don8['filename']).'")</em>\';
          out_txt += \'| <a href="#" onclick="getFileHtml('.$don8['id'].', \\\''.addslashes($don8['surname']).'\\\');return false;">generer balise html</a>\';
          out_txt += \'| <a href="#" onclick="addFile('.$don8['id'].', \\\''.addslashes($don8['surname']).'\\\', \\\'html_content_\\\');return false;">ajouter au code</a>\';
          out_txt += \'| <a href="../../../download.php?file='.$don8['id'].'&download=1">télécharger</a>|</li>\';';
      }
      $rep8->closeCursor();
    ?>
  out_txt += '  </ul>';
  openDialogBox('help_internal_files', out_txt);
}
  
function addFile(file_id, surname, form_prefix) {
  var initMarkup = '<a href=download.php?file="'+file_id+'&download=1">';
  var endMarkup = '</a>';
  var link_name = surname;
  
  var textComponent = document.getElementById(form_prefix+'text');
  var selText = getSelectedText(textComponent);
  if(selText == '') initMarkup = initMarkup+link_name;
  
  var new_text = addHTMLcode(initMarkup, endMarkup, textComponent);
  textComponent.value = new_text;
  if (typeof refreshMirrorCode == 'function') { 
    refreshMirrorCode(form_prefix+'text', form_prefix+'mirror', 'html'); }
}

</script>
