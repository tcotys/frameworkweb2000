// ----- Function that help to keep the scroll ----- //
function getScrollInput(formElem) {
  var it1;
  var max_it1 = formElem.elements.length;
  for(it1 = 0; it1 < max_it1; it1++) {
    var inputElem = formElem.elements[it1]; 
    if (inputElem.name == 'scrollInfo') {
      return inputElem;
    }
  }
  return 0;
}
function refreshScrollOnForms() {
  var formList = document.forms;
  var it1;
  var max_it1 = formList.length;
  for (it1=0; it1 < max_it1; it1++) {
    var formElem = formList[it1];
    var inputElem = getScrollInput(formElem);
    if(inputElem == 0) {
      inputElem = document.createElement("input");
      inputElem.setAttribute("type", "hidden"); 
      inputElem.setAttribute("name", "scrollInfo");
    }
    inputElem.setAttribute("value", window.pageYOffset);
    document.forms[it1].appendChild(inputElem);
  }
}
window.onscroll = refreshScrollOnForms;