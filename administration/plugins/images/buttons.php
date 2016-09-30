<script>
function addHtmlImageButton(elem, textarea_prefix)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Images";
  list_a.href = "#";
  var list_ul = document.createElement('ul');
  <?php   
    $rep4 = $bdd->query('SELECT * FROM '.getTablePrefix().'img');
    while ($don4 = $rep4->fetch()){
      ?>
        var button_elem = document.createElement('a');
            button_elem.href = "#";
            button_elem.innerHTML =  "<?php echo $don4['name']; ?>";
            button_elem.setAttribute("data-url", "<?php echo $don4['url']; ?>");
            button_elem.setAttribute("data-name", "<?php echo $don4['name']; ?>");
            button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
            button_elem.onclick = addImageInHtmlCode;
        var li_elem = document.createElement('li');
        li_elem.appendChild(button_elem);
        list_ul.appendChild(li_elem);
      <?php
    }
    $rep4->closeCursor();
  ?>
  list_li.appendChild(list_a);
  list_li.appendChild(list_ul);
  elem.appendChild(list_li);
}
function addCssImageButton(elem, textarea_prefix)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Images";
  list_a.href = "#";
  var list_ul = document.createElement('ul');
  <?php   
    $rep4 = $bdd->query('SELECT * FROM '.getTablePrefix().'img');
    while ($don4 = $rep4->fetch()){
      ?>
        var button_elem = document.createElement('a');
            button_elem.href = "#";
            button_elem.innerHTML =  "<?php echo $don4['name']; ?>";
            button_elem.setAttribute("data-url", "<?php echo $don4['url']; ?>");
            button_elem.setAttribute("data-name", "<?php echo $don4['name']; ?>");
            button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
            button_elem.onclick = addImageInCssCode;
        var li_elem = document.createElement('li');
        li_elem.appendChild(button_elem);
        list_ul.appendChild(li_elem);
      <?php
    }
    $rep4->closeCursor();
  ?>
  list_li.appendChild(list_a);
  list_li.appendChild(list_ul);
  elem.appendChild(list_li);
}
function addJsImageButton(elem, textarea_prefix)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Images";
  list_a.href = "#";
  var list_ul = document.createElement('ul');
  <?php   
    $rep4 = $bdd->query('SELECT * FROM '.getTablePrefix().'img');
    while ($don4 = $rep4->fetch()){
      ?>
        var button_elem = document.createElement('a');
            button_elem.href = "#";
            button_elem.innerHTML =  "<?php echo $don4['name']; ?>";
            button_elem.setAttribute("data-url", "<?php echo $don4['url']; ?>");
            button_elem.setAttribute("data-name", "<?php echo $don4['name']; ?>");
            button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
            button_elem.onclick = addImageInCssCode;
        var li_elem = document.createElement('li');
        li_elem.appendChild(button_elem);
        list_ul.appendChild(li_elem);
      <?php
    }
    $rep4->closeCursor();
  ?>
  list_li.appendChild(list_a);
  list_li.appendChild(list_ul);
  elem.appendChild(list_li);
}

function addImageInHtmlCode(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var name = target.getAttribute("data-name");
  var url  = target.getAttribute("data-url");
  var init_markup = '<img src="'+url+'" alt="'+name+'" />';
  var textarea_prefix = target.getAttribute("data-textarea-prefix");
  var end_marlup = '';
  addMarkup(init_markup, end_marlup, textarea_prefix);
  return false;
}
function addImageInCssCode(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var name = target.getAttribute("data-name");
  var url  = target.getAttribute("data-url");
  var init_markup = 'url("'+url+'")';
  var textarea_prefix = target.getAttribute("data-textarea-prefix");
  var end_marlup = '';
  addMarkup(init_markup, end_marlup, textarea_prefix);
  return false;
}
function addImageInJsCode(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var name = target.getAttribute("data-name");
  var url  = target.getAttribute("data-url");
  var init_markup = '"'+url+'"';
  var textarea_prefix = target.getAttribute("data-textarea-prefix");
  var end_marlup = '';
  addMarkup(init_markup, end_marlup, textarea_prefix);
  return false;
}
// ----- Old deprecated images list ----- //

function addOldImagesButton(elem)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Images";
  list_a.href = "#";
  list_a.onclick = showImagesList;
  list_li.appendChild(list_a);
  elem.appendChild(list_li);
}

function showImagesList() {
  out_txt  = '';
  out_txt += '<h2>Outils d\'affichage d\'images</h2>';
  out_txt += '<ul>';
    <?php   
      $rep4 = $bdd->query('SELECT * FROM '.getTablePrefix().'img');
      while ($don4 = $rep4->fetch()){
        echo '
          out_txt += \'  <li style="margin-left:110px;position:relative;"onmouseover="document.getElementById(\\\'img'.$don4['id'].'\\\').style.display = \\\'block\\\';" onmouseout="document.getElementById(\\\'img'.$don4['id'].'\\\').style.display = \\\'none\\\';">\';
          out_txt += \'  <img id="img'.$don4['id'].'" style="position:absolute;display:none;left:-140px;" src="../'.$don4['url'].'" width="100px" />\';
          out_txt += \'  <em style="display:inline-block;width:400px;">'.addslashes($don4['name']).'</em>\';
          out_txt += \'    | <a href="#" onclick="getImgAdress(\\\''.$don4['url'].'\\\');return false;">obtenir adresse</a>\';
          out_txt += \'    | <a href="#" onclick="addImage(\\\''.$don4['url'].'\\\', \\\''.addslashes($don4['name']).'\\\', \\\'html_content_\\\');return false;">ajouter au code</a>\';
          out_txt += \'    | <a href="#" onclick="getImgHtml(\\\''.$don4['url'].'\\\', \\\''.addslashes($don4['name']).'\\\');return false;">generer balise html</a> |</li>\';';
      }
      $rep4->closeCursor();
    ?>
  out_txt += '</ul>';
  openDialogBox('help_internal_images', out_txt);
  return false;
}

function addImage(img_url, img_name, form_prefix) {
  var initMarkup = '';
  var endMarkup = '<img src="'+img_url+'" alt="'+img_name+'" />';
  var textComponent = document.getElementById(form_prefix+'text');
  var selText = getSelectedText(textComponent);
  
  var new_text = addHTMLcode(initMarkup, endMarkup, textComponent);
  textComponent.value = new_text;
  if (typeof refreshMirrorCode == 'function') { 
    refreshMirrorCode(form_prefix+'text', form_prefix+'mirror', 'html'); }
}
</script>