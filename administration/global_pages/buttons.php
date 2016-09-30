<script>
function addHtmlGlobalPageButton(elem, textarea_prefix)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Global Pages";
  list_a.href = "#";
  var list_ul = document.createElement('ul');
  <?php   
    $rep5 = $bdd->query('SELECT * FROM '.getTablePrefix().'info WHERE id>1 ORDER BY id');
    while ($don5 = $rep5->fetch()){
      ?>
        var button_elem = document.createElement('a');
            button_elem.href = "#";
            button_elem.innerHTML =  "<?php echo $don5['name']; ?>";
            button_elem.setAttribute("data-html", "[GET_GLOBAL_PAGE:<?php echo $don5['id'] ?>]");
            button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
            button_elem.onclick = addGlobalPageInHtmlCode;
        var li_elem = document.createElement('li');
        li_elem.appendChild(button_elem);
        list_ul.appendChild(li_elem);
      <?php
    }
    $rep5->closeCursor();
  ?>
  
  var button_elem = document.createElement('a');
      button_elem.href = "#";
      button_elem.innerHTML =  "Local HTML";
      button_elem.setAttribute("data-html", "[GET_LOCAL_HTML]");
      button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
      button_elem.onclick = addGlobalPageInHtmlCode;
  var li_elem = document.createElement('li');
  li_elem.appendChild(button_elem);
  list_ul.appendChild(li_elem);
  
  var button_elem = document.createElement('a');
      button_elem.href = "#";
      button_elem.innerHTML =  "Local CSS";
      button_elem.setAttribute("data-html", "[GET_LOCAL_CSS]");
      button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
      button_elem.onclick = addGlobalPageInHtmlCode;
  var li_elem = document.createElement('li');
  li_elem.appendChild(button_elem);
  list_ul.appendChild(li_elem);
  
  
  var button_elem = document.createElement('a');
      button_elem.href = "#";
      button_elem.innerHTML =  "Local JavaScript";
      button_elem.setAttribute("data-html", "[GET_LOCAL_JAVASCRIPT]");
      button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
      button_elem.onclick = addGlobalPageInHtmlCode;
  var li_elem = document.createElement('li');
  li_elem.appendChild(button_elem);
  list_ul.appendChild(li_elem);
  
  var button_elem = document.createElement('a');
      button_elem.href = "#";
      button_elem.innerHTML =  "Local page name";
      button_elem.setAttribute("data-html", "[GET_LOCAL_PAGE_NAME]");
      button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
      button_elem.onclick = addGlobalPageInHtmlCode;
  var li_elem = document.createElement('li');
  li_elem.appendChild(button_elem);
  list_ul.appendChild(li_elem);
        
  
  var button_elem = document.createElement('a');
      button_elem.href = "#";
      button_elem.innerHTML =  "Local attaché à";
      button_elem.setAttribute("data-html", "[GET_LOCAL_ATTACHED_TO]");
      button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
      button_elem.onclick = addGlobalPageInHtmlCode;
  var li_elem = document.createElement('li');
  li_elem.appendChild(button_elem);
  list_ul.appendChild(li_elem);
  
  list_li.appendChild(list_a);
  list_li.appendChild(list_ul);
  elem.appendChild(list_li);
}

function addGlobalPageInHtmlCode(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var init_markup = target.getAttribute("data-html");;
  var textarea_prefix = target.getAttribute("data-textarea-prefix");
  var end_marlup = '';
  addMarkup(init_markup, end_marlup, textarea_prefix);
  return false;
}
// ----- Old deprecated stuffs ----- //
function addOldGlobalPagesButton(elem)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Pages Globales";
  list_a.href = "#";
  list_a.onclick = showGlobalPagesList;
  list_li.appendChild(list_a);
  elem.appendChild(list_li);
}

function showGlobalPagesList() {
  out_txt  = '';
  out_txt += '<h2>Outil d\'inclusion de pages</h2>';
  out_txt += '<p>Pour inclure une page globale (comme celle du css, inclure le script suivant :</p>';
  out_txt += '<ul>';
    <?php
      $rep5 = $bdd->query('SELECT * FROM '.getTablePrefix().'info WHERE id>1 ORDER BY id') or die(print_r($bdd->errorInfo()));
      while ($don5 = $rep5->fetch())
      {
        echo "out_txt += '  <li>".$don5['name']." (id=".$don5['id'].") : [GET_GLOBAL_PAGE:".$don5['id']."]</li>';"; 
      }
      $rep5->closeCursor();
    ?>
  out_txt += '</ul>';
  out_txt += '<p>Pour incure des éléments locaux dans la page, utiliser le code suivant</p>';
  out_txt += '<ul>';
  out_txt += '  <li>Le code HTML de la page : [GET_LOCAL_HTML]</li>';
  out_txt += '  <li>Le code CSS supplémentaire de la page : [GET_LOCAL_CSS]</li>';
  out_txt += '  <li>Le code de bibliothèque javascript : [GET_LOCAL_JAVASCRIPT]</li';
  out_txt += '  <li>Récupérer le nom de la page locale* : [GET_LOCAL_PAGE_NAME]</li>';
  out_txt += '  <li>Récupérer la page principale liée** : [GET_LOCAL_ATTACHED_TO]</li>';
  out_txt += '</ul>';
  out_txt += '<p>* Ceci permet par exemple de l\'inclure dans le titre, ou l\'entête...</p>';
  out_txt += '<p>** Ceci permet d\'avoir un menu en en surbrillance, même si ce nes pas la bonne page.<br />';
  out_txt += '  Exemple : Une sous-rubrique mettra la rubrique principale en surbrillance,...</p>';
  openDialogBox('help_global_pages', out_txt);
}

</script>