<script>
function addHtmlHelpButton(elem)
{
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "Aide HTML";
  list_a.href = "../../plugins/html_markups/tuto.php";
  list_a.target = "help";
  list_li.appendChild(list_a);
  elem.appendChild(list_li);
}


function addMarkupButtons(elem, textarea_prefix)
{
  var balise_li = document.createElement('li');
  var balise_button = document.createElement('a');
      balise_button.href = "#";
      balise_button.innerHTML =  "Balises HTML";
  balise_li.appendChild(balise_button);
  var balise_ul = document.createElement('ul');
      balise_li.appendChild(balise_ul);
  
  var bold_button = document.createElement('a');
      bold_button.href = "#";
      bold_button.innerHTML =  "Gras";
      bold_button.onclick = function() {addMarkup('<strong>', '</strong>', textarea_prefix);return false;};
  var bold_li = document.createElement('li');
  bold_li.appendChild(bold_button);
  balise_ul.appendChild(bold_li);
  
  var it_button = document.createElement('a');
      it_button.href = "#";
      it_button.innerHTML =  "Italique";
      it_button.onclick = function() {addMarkup('<em>', '</em>', textarea_prefix);return false;};
  var it_li = document.createElement('li');
  it_li.appendChild(it_button);
  balise_ul.appendChild(it_li);
  
  var h1_button = document.createElement('a');
      h1_button.href = "#";
      h1_button.innerHTML =  "Titre 1";
      h1_button.onclick = function() {addMarkup('<h1>', '</h1>', textarea_prefix);return false;};
  var h1_li = document.createElement('li');
  h1_li.appendChild(h1_button);
  balise_ul.appendChild(h1_li);
  
  var h2_button = document.createElement('a');
      h2_button.href = "#";
      h2_button.innerHTML =  "Titre 2";
      h2_button.onclick = function() {addMarkup('<h2>', '</h2>', textarea_prefix);return false;};
  var h2_li = document.createElement('li');
  h2_li.appendChild(h2_button);
  balise_ul.appendChild(h2_li);
  
  var h3_button = document.createElement('a');
      h3_button.href = "#";
      h3_button.innerHTML =  "Titre 3";
      h3_button.onclick = function() {addMarkup('<h3>', '</h3>', textarea_prefix);return false;};
  var h3_li = document.createElement('li');
  h3_li.appendChild(h3_button);
  balise_ul.appendChild(h3_li);

  var p_button = document.createElement('a');
      p_button.href = "#";
      p_button.innerHTML =  "Paragraphe";
      p_button.onclick = function() {addMarkup('<p>', '</p>', textarea_prefix);return false;};
  var p_li = document.createElement('li');
  p_li.appendChild(p_button);
  balise_ul.appendChild(p_li);
  
  elem.appendChild(balise_li);
}
</script>