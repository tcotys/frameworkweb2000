
function maximizeElem(elem) {
  var topLeft = findPos(elem); // function defined in dialogBoxes.js

  var oldTop    = topLeft.y;
  var oldLeft   = topLeft.x;
  var oldRight  = window.innerWidth  || document.documentElement.clientWidth  || document.body.clientWidth;
  var oldBottom = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

  var newWidth  = Math.abs(oldRight-oldLeft);
  var newHeight = Math.abs(oldBottom-oldTop);
  
  elem.style.width  = (newWidth-2)  + "px";
  elem.style.height = (newHeight-2) + "px";
}