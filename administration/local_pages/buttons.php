<script>
function addHtmlLinkButton(elem, textarea_prefix)
{
  var link_li = document.createElement('li');
  var out_txt  = '';
      out_txt += '<a href="#">Liens</a>';
//         out_txt += '<li><input type="button" value="Gras" onclick="addMarkup(\'<strong>\', \'</strong>\',\''+textarea_prefix+'\');" /></li>\n';
//         out_txt += '<li><input type="button" value="Paragraphe" onclick="addMarkup(\'<p>\', \'</p>\',\''+textarea_prefix+'\');" /></li>\n';
//         out_txt += '<li><input type="button" value="Italique" onclick="addMarkup(\'<em>\', \'</em>\',\''+textarea_prefix+'\');" /></li>\n';
        out_txt += '<ul class="edit_submenu">\n';
        out_txt += '  <li>\n';
        out_txt += 'Lien interne :\n';
        out_txt += '<select id="'+textarea_prefix+'internal_link_id">\n';
        <?php
          $rep7 = $bdd->query('SELECT * FROM '.getTablePrefix().'pages ORDER BY id');
          while($don7 = $rep7->fetch())
          {
            echo "        out_txt += '       <option value=\"".$don7['id']."\">".$don7['page_name']."</option>\\n';";
          }
        ?>
        out_txt += '</select>\n';
        out_txt += '<input type="button" value="Ajouter" onclick="addHtmlInternalLink(\''+textarea_prefix+'\');" />\n';
        
        out_txt += '</li><li>\n';
        out_txt += 'Lien externe :\n';
        out_txt += '<input type="text" value="Url de la page" id="'+textarea_prefix+'external_link_url" />\n';
        out_txt += '<input type="button" value="Ajouter" onclick="addExternalLink(\''+textarea_prefix+'\');" />\n';
        out_txt += '</li><li>';
        out_txt += 'Lien facebook :\n';
        out_txt += '<input type="text" id="'+textarea_prefix+'facebook_link_text" value="Texte du lien" />\n';
        out_txt += '<input type="text" id="'+textarea_prefix+'facebook_link_url"  value="Url de la page" />\n';
        out_txt += '<input type="button" value="Ajouter" onclick="addFacebookLink(\''+textarea_prefix+'\');" />\n';
        out_txt += '</li></ul>';
  link_li.innerHTML = out_txt;
  elem.appendChild(link_li);
}
function addJsLinkButton(elem, textarea_prefix)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Liens";
  list_a.href = "#";
  var list_ul = document.createElement('ul');
  <?php   
    $rep7 = $bdd->query('SELECT * FROM '.getTablePrefix().'pages ORDER BY id');
    while ($don7 = $rep7->fetch()){
      ?>
        var button_elem = document.createElement('a');
            button_elem.href = "#";
            button_elem.innerHTML =  "<?php echo $don7['page_name']; ?>";
            button_elem.setAttribute("data-id", "<?php echo $don7['id']; ?>");
            button_elem.setAttribute("data-name", "<?php echo $don7['page_name']; ?>");
            button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
            button_elem.onclick = addLinkInJsCode;
        var li_elem = document.createElement('li');
        li_elem.appendChild(button_elem);
        list_ul.appendChild(li_elem);
      <?php
    }
    $rep7->closeCursor();
  ?>
  list_li.appendChild(list_a);
  list_li.appendChild(list_ul);
  elem.appendChild(list_li);
}

function addHtmlInternalLink(form_prefix)
{
  var link_id = document.getElementById(form_prefix+'internal_link_id').value;
  var link_name = document.getElementById(form_prefix+'internal_link_id').options[document.getElementById(form_prefix+'internal_link_id').selectedIndex].text;
  
  var initMarkup = '<a href="index.php?page='+link_id+'">';
  var endMarkup  = '</a>';
  var textComponent = document.getElementById(form_prefix+'text')
  var selText = getSelectedText(textComponent);
  if(selText == '') initMarkup = initMarkup+link_name;
  
  var new_text = addHTMLcode(initMarkup, endMarkup, textComponent);
  textComponent.value = new_text;
  if (typeof refreshMirrorCode == 'function') { 
    refreshMirrorCode(form_prefix+'text', form_prefix+'mirror', 'html'); }
}
function addFacebookLink(form_prefix)
{
  var link_text = document.getElementById(form_prefix+'facebook_link_text').value;
  var link_url  = document.getElementById(form_prefix+'facebook_link_url').value;
  
  var initMarkup = '';
  var endMarkup  = '  <p class="facebookLink">\n    ';
      endMarkup  = endMarkup+'<a target="_blank" href="'+link_url+'"><img src="images/normal/facebook.png" alt="Page Facebook" /></a>\n    ';
      endMarkup  = endMarkup+'<a target="_blank" href="'+link_url+'">'+link_text+'</a>\n  </p>';
  
  var textComponent = document.getElementById(form_prefix+'text')
  
  var new_text = addHTMLcode(initMarkup, endMarkup, textComponent);
  textComponent.value = new_text;
  if (typeof refreshMirrorCode == 'function') { 
    refreshMirrorCode(form_prefix+'text', form_prefix+'mirror', 'html'); }
}
function addExternalLink(form_prefix)
{
  var link_url = document.getElementById(form_prefix+'external_link_url').value;
  var link_name = 'Texte du lien';
  
  var initMarkup = '<a href="'+link_url+'" target="_blank">';
  var endMarkup  = '</a>';
  var textComponent = document.getElementById(form_prefix+'text')
  var selText = getSelectedText(textComponent);
  if(selText == '') initMarkup = initMarkup+link_name;
  
  var new_text = addHTMLcode(initMarkup, endMarkup, textComponent);
  textComponent.value = new_text;
  if (typeof refreshMirrorCode == 'function') { 
    refreshMirrorCode(form_prefix+'text', form_prefix+'mirror', 'html'); }
}

function addLinkInJsCode(form_prefix)
{
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var id      = target.getAttribute("data-id");
  var name = target.getAttribute("data-name");
  var init_markup  = 'index.php?page='+id;
  var textarea_prefix = target.getAttribute("data-textarea-prefix");
  var end_marlup = '';
  addMarkup(init_markup, end_marlup, textarea_prefix);
  return false;
}

// ----- Old deprecated stuffs ----- //
function addOldLocalPagesButton(elem)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Pages Locales";
  list_a.href = "#";
  list_a.onclick = showPagesList;
  list_li.appendChild(list_a);
  elem.appendChild(list_li);
}

function showPagesList() {
  out_txt  = '';
  out_txt += '<h2>Outils de liens internes</h2>';
  out_txt += '<ul>';
  <?php
    $rep3 = $bdd->query('SELECT * FROM '.getTablePrefix().'pages');
    while ($don3 = $rep3->fetch()){
      echo 'out_txt += \'<li><span class="page_name"> '.getHtmlFromMysql($don3['page_name']).'</span> | <a href="#" onclick="getPageLink('.$don3['id'].'); return false;">generer lien</a> |</li>\';'; }
    $rep3->closeCursor();
  ?>
  out_txt + '</ul>';
  openDialogBox('help_internal_pages', out_txt);
}
</script>