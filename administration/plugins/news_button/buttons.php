<script>
function addHtmlNewsButton(elem, textarea_prefix)
{
  var html_textarea_id = textarea_prefix+'text';
  var list_li = document.createElement('li');
  var list_a  = document.createElement('a');
  list_a.innerHTML = "News";
  list_a.href = "#";
  list_a.onclick = function() {openAddNewsDialogBox(html_textarea_id);};
  list_li.appendChild(list_a);
  elem.appendChild(list_li);
}

function openAddNewsDialogBox(html_textarea_id)
{
  var out_txt = '<input id="addNews_date" type="text" value="today" /><br />\n';
      out_txt = out_txt + '<textarea id="addNews_text" cols="80" rows="15"></textarea>\n';
      out_txt = out_txt + '<div id="news_markups"></div>\n';
      out_txt = out_txt + '<input type="button" value="Générer" onclick="generate_news(\''+html_textarea_id+'\');" />';
  
  openDialogBox('create_news' ,out_txt); 
  
  addMarkupButtons(document.getElementById('news_markups'), 'addNews_');
}

function getFrDate() {
  month_num2str = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
  todayDate = new Date();
  todayDay  = todayDate.getDate();
  todayMonth = todayDate.getMonth();
  todayYear = todayDate.getFullYear();
  
  return todayDay+' '+month_num2str[todayMonth]+' '+todayYear;
}
function generate_news(html_textarea_id)
{
  var news_form = document.getElementById('addNews_form');
  var news_date = document.getElementById('addNews_date').value;
  var news_text = document.getElementById('addNews_text').value;
  
  if (news_date.toLowerCase() == 'today') news_date = getFrDate();
  
  var news_out = '<article>\n  <h2>\n    ' + news_date + '\n  </h2>\n  <p>\n    ';
  
      news_text = news_text.replace(/(?:\r\n|\r|\n){2}/g, '\n  </p>\n  <p>\n    ');
      news_out = news_out + news_text + '\n  </p>\n</article>';
  var show_news =  document.getElementById(html_textarea_id);
  var show_news_old = show_news.value;
      show_news_new = show_news_old.replace(/(<!-- News Start -->)/, "$1\n\n"+news_out);
  
  show_news.value = show_news_new;
  if (typeof refreshMirrorCode == 'function') { 
    refreshMirrorCode(html_textarea_id, html_textarea_id.substring(0,html_textarea_id.length-4)+'mirror', 'html'); }
  closeDialogBox('create_news');
}
</script>