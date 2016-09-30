function addMarkup(initMarkup, endMarkup, form_prefix)
{
  var textComponent = document.getElementById(form_prefix+'text');
  var new_text = addHTMLcode(initMarkup, endMarkup, textComponent);
  textComponent.value = new_text;
  if (typeof refreshMirrorCode == 'function') { 
    refreshMirrorCode(form_prefix+'text', form_prefix+'mirror', 'html'); }
} 

function addHTMLcode(initMarkup, endMarkup, textComponent)
{
//     var textComponent = document.getElementById('create_news_text');
  var beforSelText;
  var selectedText;
  var afterSelText;
  
  if (textComponent.selectionStart != undefined) // dont work under IE<9
  {
    var startPos = textComponent.selectionStart;
    var endPos   = textComponent.selectionEnd;
    beforSelText = textComponent.value.substring(0,startPos);
    selectedText = textComponent.value.substring(startPos, endPos);
    afterSelText = textComponent.value.substring(endPos);
  }
  else
  {
    alert('You need another web browser, if you want to make this...');
  }
  return beforSelText+initMarkup+selectedText+endMarkup+afterSelText;
}

function getSelectedText(textComponent)
{
  var selectedText;
  
  if (textComponent.selectionStart != undefined) // dont work under IE<9
  {
    var startPos = textComponent.selectionStart;
    var endPos = textComponent.selectionEnd;
    selectedText = textComponent.value.substring(startPos, endPos);
  }
  else
  {
    alert('You need another web browser, if you want to make this...');
  }
  return selectedText;
}