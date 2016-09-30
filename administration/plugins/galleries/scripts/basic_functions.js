// ----- Functions utiles ----- //
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

function getScrollTop(){ // quid de pageYOffset
    if(typeof pageYOffset!= 'undefined'){ //most browsers except IE before #9
        return pageYOffset;}
    else{ //IE with doctype
        var B= document.body; //IE 'quirks'
        var D= document.documentElement; 
        D= (D.clientHeight)? D: B;
        return D.scrollTop;}}


function getScrollLeft(){ // quid de pagexOffset
    if(typeof pageXOffset!= 'undefined'){ //most browsers except IE before #9
        return pageXOffset;}
    else{ //IE with doctype
        var B= document.body; //IE 'quirks'
        var D= document.documentElement; 
        D= (D.clientWidth)? D: B;
        return D.scrollLeft;}}

function getNaturalHeight(img){
  if(typeof img.naturalHeight == "undefined") {
    var temp_image = new Image();
    temp_image.src = img.src;
    return temp_image.height;}
  else {
    return img.naturalHeight;}}

function getNaturalWidth(img) {
  if(typeof img.naturalWidth == "undefined") {
    var temp_image = new Image();
    temp_image.src = img.src;
    return temp_image.width;}
  else {
    return img.naturalWidth;}}