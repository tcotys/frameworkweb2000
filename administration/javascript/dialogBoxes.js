// -------------------------------------------------------------------------------------- //
//                                                                                        //
//                  Ensemble de fonction ayant trait au rendu graphique.                  //
//               Ces fonction générales n'ont pas spécialement à être placé               //
//                       au sein de la classe des project de cablage                      //
//                                                                                        //
// -------------------------------------------------------------------------------------- //

// ------------------------------------------------ //
// ---------- Quelques fonctions de base ---------- //
// ------------------------------------------------ //
function findPos(el)
{
 var x = y = 0;
 if(el.offsetParent)
 {
   x = el.offsetLeft;
   y = el.offsetTop;
   while(el = el.offsetParent)
   {
     x += el.offsetLeft;
     y += el.offsetTop;
    }
  }
  return {'x':x, 'y':y};
}
     
function getMousePos(e)
{
  var posx = 0;
  var posy = 0;
  if (!e) var e = window.event;
  if (e.pageX || e.pageY)
  {
    posx = e.pageX;
    posy = e.pageY;
  }
  else if (e.clientX || e.clientY)
  {
    posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
    posy = e.clientY + document.body.scrollTop  + document.documentElement.scrollTop;
  }
  return {'x':posx, 'y':posy};
}
  
function addEvent(element, event, func)
{
  if (element.addEventListener)
  {
    element.addEventListener(event, func, false);
  }
  else
  {
   element.attachEvent('on' + event, func);
  }
}

function removeEvent(element, event, func)
{
  if (element.removeEventListener)
  {
    element.removeEventListener(event, func, false);
  }
  else
  {
   element.detachEvent('on' + event, func);
  }
}

//     http://stackoverflow.com/questions/4976936/get-the-available-browser-window-size-clientheight-clientwidth-consistently-ac
var getWindowSize = (function() {
  var docEl = document.documentElement,
      IS_BODY_ACTING_ROOT = docEl && docEl.clientHeight === 0;

  // Used to feature test Opera returning wrong values 
  // for documentElement.clientHeight. 
  function isDocumentElementHeightOff () { 
      var d = document,
          div = d.createElement('div');
      div.style.height = "2500px";
      d.body.insertBefore(div, d.body.firstChild);
      var r = d.documentElement.clientHeight > 2400;
      d.body.removeChild(div);
      return r;
  }

  if (typeof document.clientWidth == "number") {
     return function () {
       return { width: document.clientWidth, height: document.clientHeight };
     };
  } else if (IS_BODY_ACTING_ROOT || isDocumentElementHeightOff()) {
      var b = document.body;
      return function () {
        return { width: b.clientWidth, height: b.clientHeight };
      };
  } else {
      return function () {
        return { width: docEl.clientWidth, height: docEl.clientHeight };
      };
  }
})();

// ------------------------------------------------ //
// ---------- Boite de dialogue standard ---------- //
// ------------------------------------------------ //

// ----- fermeture de la boite de dialogue...
function closeDialogBox(dialog_box_id, destructionFunction)
{
  var old_dialog_box = document.getElementById(dialog_box_id);
  if (old_dialog_box)
  {
    old_dialog_box.parentNode.removeChild(old_dialog_box);
  }
  if(destructionFunction)
  {
    destructionFunction();
  }
}
// ----- Ouverture de la boirte de dialogue
function openDialogBox(dialog_box_id, input_innerHTML, destructionFunction)
{
  var old_dialog_box = document.getElementById(dialog_box_id);
  if (old_dialog_box)
  {
    old_dialog_box.parentNode.removeChild(old_dialog_box);
  }
  var closeButtonBase64  = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAkCAYAAADl9UilAAAAGXRFWHRTb2Z0d2FyZQBBZG9i";
      closeButtonBase64 += "ZSBJbWFnZVJlYWR5ccllPAAABG1JREFUeNrMWE1IW1sQniQ3SdPn04pWC/K6URRa/1o3LgS3ivi3ELoTKerC/z9QREErgv";
      closeButtonBase64 += "iDgq7EP6zg0k0tFldirbzFK+WtRHChvoUPNcXE1sT8dOb03HBM7r1JaG7bgY/c5EzmfHdmzpwzxwB3xRAGsRB/GASIiISM";
      closeButtonBase64 += "CBOHWXiOFTmRgJfjVnj2yeOSQIwI0HcL4h6Hlf9m4qRjIT5OwoNwI24QX/mzh48xYrKn6NmG+APxJ8d9gVwsiREBF+ILws";
      closeButtonBase64 += "FxzQkGQmrkkz9A/IXIr6ioeHFwcPDe6XRe+nUSh8NhpzloLpqTz/2Ac2FOMHEvPUI8bWxsrLu5uXH6f5LQXM3NzS9pbs6B";
      closeButtonBase64 += "uJgMPMkpZImI1MPDw+mMjIzC3d1dWFpagouLC9BDkpKSoK6uDoqKiuDo6Ojv9PT0Vvz5DGGnEMvEKJ+SEWkul+uNxWKx1d";
      closeButtonBase64 += "bWgt1uBz0lISEBVldX4fb21oVzluJP/yHOKeckoUTQs5VI0Z8uzs9Bb7FfXrJPs9ls5bkllyijJNQnmRwTr8+naVSSJPB4";
      closeButtonBase64 += "PLHkKTuJ8RHrmFEsCV6vV9VCfX09ZGVlQX9/P2DoVfU6OzvZ+NzcXCTEjAIxkIJ2AAhHrKWlBaqqqtjzyMgI9PX1KZLr7u";
      closeButtonBase64 += "6GkpKS78YNBpiZmYnUcwbQKppELBjt7e0BUiR5eXkwNjbGwirqtba2QmlpaUAPaxX7r5JNLfcpE8P8EfH0yRMoKysL0cvJ";
      closeButtonBase64 += "yYHx8XGQTCam19TUBJWVlSF65eXl8PzZsxC7URPz4NuI+OfjRxgaGgKfwqLIzc2FyakpaEOv1NTUKNqbnp6GD/v7IXa1Vo";
      closeButtonBase64 += "Kqx4Ll7eYmuDGfhl+9oiV+Z4zCSlCSqclJWF9fj3qJqnpMSbbevQOH0wmTOJnVag07wRR68vXaWtS1Qz2U6DE17OzssFzS";
      closeButtonBase64 += "KhUkExMTsLy8rGkrpsQIe3t7sImhVZOzszPY2NgIayf6VamwtEWQx6qrq1UNp6amwuLiItsPtezE1GN4TGHEwklmZibMz8";
      closeButtonBase64 += "+DzWbTP5RUPKn6RyrZ2dksz9TIxSSUVL3b2toU9Xt6emBgYEBxLD8/n4WVSkykoZS0PCZKWloaNDQ0KOr29vayc5X8QqOj";
      closeButtonBase64 += "oyE6BQUFUFhYCNvb2z9WLoLf7Pj4mFX1q6urO3qDg4OwsLAQ0KOc6urqCrFH3t7a2oo6+f2RhHIftxSR3PDwMMzOzobo0Z";
      closeButtonBase64 += "G8o6MjYIvycg2LbISr0i+G0s/bKl+4Yw+Row25uLhY8yhDOUUFOD4+HlZWViJt6+SGl519aF+JRzxEPMbG5S0NxMXFwc8Q";
      closeButtonBase64 += "bBHlMxudk04Q/yOupKDO2OV2u7/SuT8xMRHOdT73Jycns09qRngDLF8X+OQc8/IW/cvp6em/8uabkpLCjjl6gGzTHCQnJy";
      closeButtonBase64 += "efeFfu5lwgpOGl5vN3aHhVrwiw8f1wfX39WS9CZJvmEK4IHotXBGLrZv5NLlVYnhmEeiZeQ9n4NZTlF11D+dQu7iSBkN4X";
      closeButtonBase64 += "dx6RkDxuiOCq06jWe/4AORBJKF11fhNgAIJW92K2HFLLAAAAAElFTkSuQmCC";
      
  var dialog_box                             = document.createElement('div');
      dialog_box.id                          = dialog_box_id;
      dialog_box.style.border                = "1px solid black";
      dialog_box.style.webkitborderRadius    = "5px";
      dialog_box.style.MozborderRadius       = "5px";
      dialog_box.style.msborderRadius        = "5px";
      dialog_box.style.OborderRadius         = "5px";
      dialog_box.style.borderRadius          = "5px";
      dialog_box.style.padding               = "0px";
      dialog_box.style.paddingTop            = "0px";
      dialog_box.style.backgroundColor       = "white";
      dialog_box.style.zIndex                = "10";
      dialog_box.style.position              = "absolute";
  var before_innerHTML                       = document.createElement('p');
      before_innerHTML.style.textAlign       = "right";
      before_innerHTML.style.marginTop       = "0px";
      before_innerHTML.style.paddingRight    = "15px";
      before_innerHTML.style.backgroundColor = "#39637F";
      before_innerHTML.style.cursor          = "move";
      before_innerHTML.style.borderBottom    = "2px solid black";
      before_innerHTML.style.fontSize        = "0px";
      before_innerHTML.style.paddingRight    = "5px";
      before_innerHTML.id                    = dialog_box_id+"Move";
      
  var before_innerHTML_img                    = document.createElement('img');
      before_innerHTML_img.id                 = dialog_box_id+"Close"
      before_innerHTML_img.src                = closeButtonBase64;
      before_innerHTML_img.height             = 20;
      before_innerHTML_img.style.cursor       = "pointer";
      before_innerHTML_img.onclick            = function()
  {
    closeDialogBox(dialog_box_id, destructionFunction);
    return false;
  }
  var dialog_box_text                        = document.createElement('div');
      dialog_box_text.style.margin           = "10px";
      dialog_box_text.innerHTML              = input_innerHTML;
      
  before_innerHTML.appendChild(before_innerHTML_img);
  dialog_box.appendChild(before_innerHTML);
  dialog_box.appendChild(dialog_box_text);
  document.body.appendChild(dialog_box);
  
  if(typeof moveButton[dialog_box_id] === 'undefined')
  {
    dialog_box_top  = Math.max(window.pageYOffset, Math.round(window.pageYOffset + (getWindowSize().height-dialog_box.offsetHeight)/2));
    dialog_box_left = Math.max(window.pageXOffset, Math.round(window.pageXOffset + (getWindowSize().width -dialog_box.offsetWidth )/2));
    moveButton[dialog_box_id] = new MoveButtomElem();
    moveButton[dialog_box_id].top = dialog_box_top;
    moveButton[dialog_box_id].left = dialog_box_left;
  }
  dialog_box.style.top                     = moveButton[dialog_box_id].top +"px";
  dialog_box.style.left                    = moveButton[dialog_box_id].left+"px";
  addEvent(document.getElementById(dialog_box_id+"Move"), "mousedown", initMoveDialogBox);
  addEvent(document, "mousemove", moveDialogBox);
}

// ----- Génération d'un bouton "MOVE" ----- //
var moveButton = [];
function MoveButtomElem ()
{
  this.clicked     = false;
  this.internal_dx = 0;
  this.internal_dy = 0;
  this.top         = 0;
  this.left        = 0;
  
  this.setDxDy     = function(newDx, newDy)
  {
    this.internal_dx = newDx;
    this.internal_dy = newDy;
  }
}
function initMoveDialogBox(e)
{
  var ev = e || window.event;
  if (ev.preventDefault) {
    ev.preventDefault();}
  ev.returnValue = false;
  
  var target           = ev.target || ev.srcElement;
  
  if (target.id.substring(target.id.length-5,target.id.length) != "Close")
  {
    var dialogBoxMove_id = target.id; //attention ce n'est pas un objet string ...
    var dialogBox_id     = dialogBoxMove_id.substring(0,dialogBoxMove_id.length-4);
    var dialogBox        = document.getElementById(dialogBox_id);

    var dialogBox_pos    = findPos(dialogBox);
    var mouse_pos        = getMousePos(ev);
    var internal_dx      = mouse_pos.x-dialogBox_pos.x;
    var internal_dy      = mouse_pos.y-dialogBox_pos.y;

    moveButton[dialogBox_id].clicked     = true;
    moveButton[dialogBox_id].internal_dx = internal_dx;
    moveButton[dialogBox_id].internal_dy = internal_dy;

    return false;
  }
}

function moveDialogBox(e)
{
  var ev = e || window.event;
  if (ev.preventDefault) {
    ev.preventDefault();}
  ev.returnValue = false;
  
  var mouse_pos        = getMousePos(ev);
  var graphic_pos      = findPos(document.body);
  for(dialogBox_id in moveButton)
  {
    if(moveButton[dialogBox_id].clicked)
    {
      moveButton[dialogBox_id].top  = (mouse_pos.y - graphic_pos.y - moveButton[dialogBox_id].internal_dy);
      moveButton[dialogBox_id].left = (mouse_pos.x - graphic_pos.x - moveButton[dialogBox_id].internal_dx);
      var dialogBox                 = document.getElementById(dialogBox_id);
      dialogBox.style.top           = (mouse_pos.y - graphic_pos.y - moveButton[dialogBox_id].internal_dy)+"px";
      dialogBox.style.left          = (mouse_pos.x - graphic_pos.x - moveButton[dialogBox_id].internal_dx)+"px";
    }
  }
  return false;
}
function endMoveDialogBox(e)
{
  for(dialogBox_id in moveButton)
  {
    moveButton[dialogBox_id].clicked = false;
  }
  return false;
}
addEvent(document, "mouseup", endMoveDialogBox);