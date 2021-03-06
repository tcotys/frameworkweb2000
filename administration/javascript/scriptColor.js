function setMirrorScroll(code_id, mirror_id) {
  document.getElementById(mirror_id).scrollTop  = document.getElementById(code_id).scrollTop;
  document.getElementById(mirror_id).scrollLeft = document.getElementById(code_id).scrollLeft;
}
function setMirrorSize(code_id, mirror_id) {
  var code_elem   = document.getElementById(code_id);
  var mirror_elem = document.getElementById(mirror_id);
  var parent_elem = document.getElementById(mirror_id).parentNode;
  mirror_elem.style.height = code_elem.clientHeight+"px";
  mirror_elem.style.width  = code_elem.clientWidth +"px";
  
  parent_elem.style.height = code_elem.offsetHeight+"px";
  parent_elem.style.width  = code_elem.offsetWidth+"px";
}
function refreshMirrorCode(code_id, mirror_id, language) {
  
  var code_elem  = document.getElementById(code_id),
      cursor_start = code_elem.selectionStart,
      cursor_end  = code_elem.selectionEnd;
  
  var script_in  = code_elem.value;
  if(cursor_start == cursor_end) {
    script_in_start = script_in.substr(0, cursor_start);
    script_in_end   = script_in.substr(cursor_end);
    script_in = script_in_start+'[CURSOR]'+script_in_end;
  }
      script_in  = script_in.replace(/&/g, '&amp;'); 
      script_in  = script_in.replace(/\//g, '&#47;');
      script_in  = script_in.replace(/</g, '&lt;');
      script_in  = script_in.replace(/>/g, '&gt;');
      script_in  = script_in.replace(/"/g, '&quot;');
      script_in  = script_in.replace(/'/g, '&apos;');
  if (language == 'html') {
      script_in  = script_in.replace(/(&lt;[a-zA-Z](.*?)&gt;)/g, '<span style="color:green;">$1</span>'); // balises en vert
      script_in  = script_in.replace(/(&lt;&#47;[a-zA-Z](.*?)&gt;)/g, '<span style="color:green;">$1</span>'); // balises en vert
//       script_in  = script_in.replace(/[^#](\d+?)/g, '<span style="color:yellow;">$1</span>');// chiffres en jaune
      script_in  = script_in.replace(/(&lt;!--(.+?)--&gt;)/g, '<span style="color:lightgrey;">$1</span>'); // commentaires en gris
      script_in  = script_in.replace(/(&quot;(.+?)&quot;)/g, '<span style="color:magenta;">$1</span>'); // guillements en rose
    
  }
  else if (language == 'css') {
      script_in  = script_in.replace(/([a-z\-]+?)([\s]*?):([^&\.]+?);/g , '<strong>$1</strong>$2:<span style="color:blue;">$3</span>;');
      script_in  = script_in.replace(/(\.[a-zA-Z0-9_]+?[\{\.,\#\s])/g, '<span style="color:yellow;">$1</span>');
      script_in  = script_in.replace(/(\#[a-zA-Z0-9_]+?[\{\.,\#\s])/g, '<span style="color:green;">$1</span>');
      script_in  = script_in.replace(/\{([\W\w\n\r]+?)\}/g , '<span style="color:darkgrey;font-weight:bold;">&#123;</span>$1<span style="color:darkgrey;font-weight:bold;">&#125;</span>');      
      script_in  = script_in.replace(/(&#47;\*(.+?)\*&#47;)/mg, '<span style="color:lightgrey;">/*$2*/</span>'); // commentaires en gris
      script_in  = script_in.replace(/(&quot;(.+?)&quot;)/g, '<span style="color:magenta;">$1</span>'); // guillements en rouge
      script_in  = script_in.replace(/(&apos;(.+?)&apos;)/g, '<span style="color:red;">$1</span>');// guillements en rouge     
  }
  else if (language == 'javascript') {
      script_in  = script_in.replace(/(&quot;(.+?)&quot;)/g, '<span style="color:magenta;">$1</span>'); // guillements en rouge
      script_in  = script_in.replace(/(&apos;(.+?)&apos;)/g, '<span style="color:red;">$1</span>');// guillements en rouge
  }
    script_in  = script_in.replace(/(\[CURSOR\])/g, '<span style="position:relative;display:inline-block;height:14px;"><span style="display:inline-block;position:absolute;width:1px;height:18px;background-color:black;"></span></span>');
  var script_out = script_in.replace(/(?:\r\n|\r|\n)/g, '<br />');
  document.getElementById(mirror_id).innerHTML = script_out+'<br />';
  setMirrorScroll(code_id, mirror_id);
}

function setCodeAndMirrorCSS(code_id, mirror_id) {
  var code_style               = document.getElementById(code_id).style;
  var mirror_style             = document.getElementById(mirror_id).style;
  var parent_style             = document.getElementById(code_id).parentNode.style;
  
  parent_style.position        = "relative";
  parent_style.textAlign       = "left";
  
  code_style.position          = "absolute";
  code_style.fontFamily        = "Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace";
  code_style.fontSize          = "12pt";
  code_style.wordBreak         = "break-all";
  code_style.wordWrap          = "break-word";
  code_style.whiteSpace        = "pre-wrap";
  code_style.borderWidth       = "2px";
  code_style.borderStyle       = "groove";
  code_style.margin            = "0px";
  code_style.padding           = "0px";
  
  code_style.zIndex            = "1";
  code_style.color             = "transparent";
  code_style.backgroundColor   = "transparent";
  code_style.overflow          = "scroll";
  code_style.resize            = "both";
  document.getElementById(code_id).setAttribute('wrap', 'hard');
  
  mirror_style.position        = "absolute";
  mirror_style.fontFamily      = "Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace";
  mirror_style.fontSize        = "12pt";
  mirror_style.wordBreak       = "break-all";
  mirror_style.wordWrap        = "break-word";
  mirror_style.whiteSpace      = "pre-wrap";
  mirror_style.borderWidth     = "2px";
  mirror_style.borderStyle     = "groove";
  mirror_style.margin          = "0px";
  mirror_style.padding         = "0px";
  
  mirror_style.zIndex          = "0";
  mirror_style.color           = "black";
  mirror_style.backgroundColor =  "white";
  mirror_style.overflow        = "hidden";
  
  mirror_style.height          = document.getElementById(code_id).clientHeight+"px";
  mirror_style.width           = document.getElementById(code_id).clientWidth+"px";
}

function addEvent(element, event, func) {
  if (element.addEventListener) {
    element.addEventListener(event, func, false);}
  else {
  element.attachEvent('on' + event, func);}}

function removeEvent(element, event, func) {
  if (element.removeEventListener) {
    element.removeEventListener(event, func, false);}
  else {
  element.detachEvent('on' + event, func);}}
  
function addInputEvent(elem, func) {  
  if (elem.addEventListener) {
    elem.addEventListener('input', func, false);}
  else if (elem.attachEvent) { // IE8 compatibility
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){ //test for MSIE x.x;
      var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
      if (ieversion<=8)
        elem.attachEvent('onkeyup', func );}
      else {
        elem.attachEvent('onpropertychange', func); }}}

function removeInputEvent(elem, func) {  
  if (elem.removeEventListener) {
    elem.removeEventListener('input', func, false);}
  else if (elem.detachEvent) { // IE8 compatibility
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){ //test for MSIE x.x;
      var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
      if (ieversion<=8)
        elem.detachEvent('onkeyup', func );}
      else {
        elem.detachEvent('onpropertychange', func); }}}
  
function setMirror(code_id, mirror_id, language) {
  setCodeAndMirrorCSS(code_id, mirror_id);
  
  setMirrorScroll(code_id, mirror_id);
  setMirrorSize(code_id, mirror_id);
  refreshMirrorCode(code_id, mirror_id, language);
  
  var code_elem = document.getElementById(code_id);
  addEvent(code_elem, 'scroll', function() {setMirrorScroll(code_id, mirror_id);});
  addEvent(code_elem, 'mouseup', function() {setMirrorSize(code_id, mirror_id);});
  addInputEvent(code_elem, function() {refreshMirrorCode(code_id, mirror_id, language);});
  addEvent(code_elem, 'click', function() {refreshMirrorCode(code_id, mirror_id, language);});
  addEvent(code_elem, 'keyup', function() {refreshMirrorCode(code_id, mirror_id, language);});
//   addEvent(code_elem, 'mouseup', function() {showTextSelector(code_elem);});
//   addInputEvent(code_elem, function() {showTextSelector(code_elem);});
}

function unsetMirror(code_id, mirror_id, language) {
  var code_elem = document.getElementById(code_id);
  document.getElementById(mirror_id).innerHTML =  "";
  code_elem.style.color = "black";
  removeEvent(code_elem, 'scroll', function() {setMirrorScroll(code_id, mirror_id);});
  removeEvent(code_elem, 'mouseup', function() {setMirrorSize(code_id, mirror_id);});
  removeInputEvent(code_elem, function() {refreshMirrorCode(code_id, mirror_id, language);});
  removeEvent(code_elem, 'click', function() {refreshMirrorCode(code_id, mirror_id, language);});
  removeEvent(code_elem, 'keyup', function() {refreshMirrorCode(code_id, mirror_id, language);});
//   removeEvent(code_elem, 'mouseup', function() {showTextSelector(code_elem);});
//   removeInputEvent(code_elem, function() {showTextSelector(code_elem);});
}

// ----- Old Cursor version that doesn't work ----- //
// https://developer.mozilla.org/en-US/docs/Web/API/document.createRange
// http://www.quirksmode.org/dom/range_intro.html
// http://stackoverflow.com/questions/17566323/calculating-xy-position-of-text-selection
// function showTextSelector (textComponent) {
// //   var selection    = document.getSelection();
// //   var range       = selection.getRangeAt();
// //   var clientRects = range.getClientRects();
// //http://docs.webplatform.org/wiki/dom/Element/parentTextEdit
// //    if (!oSource.isTextEdit) 
// //        oSource = oSource.parentTextEdit;
//   if (window.getSelection) {
//     var userSelection = window.getSelection();
//     if (userSelection && userSelection.rangeCount == 0) {
//       var range = document.createRange();
// //       console.log(textComponent);
//       range.setStart(textComponent.parentNode.lastChild,textComponent.parentNode.lastChild.selectionStart);
//       range.setEnd(textComponent.parentNode.lastChild,textComponent.parentNode.lastChild.selectionEnd);
//     }
//     else {
//       var range = window.getSelection().getRangeAt(0);
//     }
//   }
//   else if (document.selection) { // should come last; Opera! and SAfari or stuffs...
//     var userSelection = document.selection.createRange();
//     var range = document.createRange();
//     range.setStart(selectionObject.anchorNode,selectionObject.anchorOffset);
//     range.setEnd(selectionObject.focusNode,selectionObject.focusOffset);
//   }
//   console.log(range);
//   
// //   var range       = selection.getRangeAt();
//   var clientRects = range.getClientRects();
//   console.log(clientRects);
//   
// //   if (clientRects.width == 0) {
//     var cursorElem = document.getElementById('textarea_cursor');
//     if(cursorElem == null) {
//       cursorElem = document.createElement('div');
//     }
//     else {
//       cursorElem.parentNode.removeChild(cursorElem);
//     }
//     cursorElem.id                    =  'textarea_cursor';
//     cursorElem.style.width           = "5px";
// //     cursorElem.style.height          = clientRects.height+"px";
//     cursorElem.style.height          = "20px";
//     cursorElem.style.position        = "absolute";
//     cursorElem.style.zIndex          = 5;
//     cursorElem.style.top             = Math.round(clientRects.y)+"px";
//     cursorElem.style.left            = Math.round(clientRects.x)+"px";
//     cursorElem.style.backgroundColor = "#000000";
//     textComponent.parentNode.insertBefore(cursorElem, textComponent);
// //     textComponent.parentNode.appendChild(cursorElem);
// //   }
// }