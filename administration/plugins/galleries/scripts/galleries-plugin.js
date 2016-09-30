// ----- This page need the shortcut.js and basic_functions.js imported first

// ----- Preload Gallery images ----- //
function resizeZoom2() {
  var zoomDiv = document.getElementById('zoom');
  var zoomImg = document.getElementById('zoomImg');
  var imgHeight  = zoomImg.offsetHeight, imgWidth = zoomImg.offsetWidth;
  var divHeight  = imgHeight, divWidth = (imgWidth+40+40+42);
  var diffHeight = 0, diffWidth = 124;
  var pageHeight =
window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight, pageWidth
=window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth;
  var imgNatWidth = getNaturalWidth(zoomImg), imgNatHeight = getNaturalHeight(zoomImg);

  if((imgNatHeight+diffHeight) >= pageHeight && (imgNatWidth+diffWidth) >= pageWidth) {
    if ((imgNatHeight+diffHeight)/pageHeight >= (imgNatWidth+diffWidth)/pageWidth) {
      zoomImg.style.height = (pageHeight-diffHeight)+'px';
      zoomImg.style.width  = 'auto';
    }
    else {
      zoomImg.style.height = 'auto';
      zoomImg.style.width  = (pageWidth-diffWidth)+'px';
    }
  }
  else if ((imgNatHeight+diffHeight) >= pageHeight) {
    zoomImg.style.height = (pageHeight-diffHeight)+'px';
    zoomImg.style.width  = 'auto';}
  else if ((imgNatWidth+diffWidth) >= pageWidth) {
    zoomImg.style.height = 'auto';
    zoomImg.style.width  = (pageWidth-diffWidth)+'px';
  }
  else {
    zoomImg.style.height = 'auto';
    zoomImg.style.width  = 'auto';
  }

  zoomDiv.style.height = (zoomImg.height +diffHeight) +'px';
  zoomDiv.style.width  = (zoomImg.width  +diffWidth )+ 'px';
  zoomDiv.style.paddingTop    = Math.round(Math.max(0,
(pageHeight-(zoomImg.height+diffHeight))/2))+'px';
  zoomDiv.style.paddingBottom = Math.round(Math.max(0,
(pageHeight-(zoomImg.height+diffHeight))/2))+'px';
  zoomDiv.style.paddingLeft   = Math.round(Math.max(0, (pageWidth -(zoomImg.width +diffWidth
))/2))+'px';
  zoomDiv.style.paddingRight  = Math.round(Math.max(0, (pageWidth -(zoomImg.width +diffWidth
))/2))+'px';
}

function showZoom2(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  var galleryElem = target.parentNode;

  gallery.id       = galleryElem.getAttribute("data-id");
  gallery.nb_img   = galleryElem.getAttribute("data-nb-img");
  gallery.name     = galleryElem.getAttribute("data-name");
  gallery.author   = galleryElem.getAttribute("data-author");
  gallery.img_id   = target.getAttribute("data-img-id");
  gallery.shown    = 1;
  
  var url = 'galleries/'+gallery.id+'/large/'+gallery.img_id+'.jpg';
  
  document.getElementById('zoomImg').src = url;
  document.getElementById('zoom').style.display = "block";
  shortcut.add("left" , prevImg2 , {'type':'keyup'});
  shortcut.add("up"   , prevImg2 , {'type':'keyup'});
  shortcut.add("down" , nextImg2 , {'type':'keyup'});
  shortcut.add("right", nextImg2 , {'type':'keyup'});
  shortcut.add("esc"  , hideZoom2, {'type':'keyup'});
  
  return false;
}

function hideZoom2() {
  document.getElementById('zoom').style.display = "none";
  gallery.shown = 0;
  shortcut.remove("right");
  shortcut.remove("left");
  shortcut.remove("down");
  shortcut.remove("up");
  shortcut.remove("esc");
  
  return false;
}


// Ferme la gallerie si on clique à côté
function checkOutZoomBox2(e){
  var ev = e || window.event;
  if (ev.preventDefault) {
    ev.preventDefault();
  }
  ev.returnValue = false;
  var target = ev.target || ev.srcElement;
  if(target.id!='zoomImg' && target.id!='linkNextImg'
      && target.id!='linkPrevImg' && gallery.shown == 1) {
    hideZoom2();
  }
}

function nextImg2() {
  gallery.img_id++;
  if(gallery.img_id > gallery.nb_img) {
    hideZoom2();
  }
  else {
    var url = 'galleries/'+gallery.id+'/large/'+gallery.img_id+'.jpg';
    document.getElementById('zoomImg').src = url;
  }
  return false;
}
  
function prevImg2() {
  gallery.img_id--;
  if(gallery.img_id < 1) {
    hideZoom2();
  }
  else {
    var url = 'galleries/'+gallery.id+'/large/'+gallery.img_id+'.jpg';
    document.getElementById('zoomImg').src = url;
  }
  return false;
}


// ----- Affiche la série d'images ----- //

function addGalery2(elem) {
  var nb_img = elem.getAttribute("data-nb-img");
  var gal_id = elem.getAttribute("data-id");
  var name   = elem.getAttribute("data-name");
  var author = elem.getAttribute("data-author");
  
  var titleElem = document.createElement('h2');
      titleElem.innerHTML = "Gallerie photos : "+name;
  elem.appendChild(titleElem);

  var url = 'galleries/'+gal_id+'/mini/';
  var it2;
  for (it2=1; it2 <= nb_img; it2++) {
    // console.log(it2);
    var miniImg = document.createElement('img');
    miniImg.src = url+it2+'.jpg';
    miniImg.className = "miniImg";
    miniImg.alt = 'Image '+it2;
    miniImg.onclick = showZoom2;
    miniImg.setAttribute("data-img-id", it2);
    elem.appendChild(miniImg);
    delete window.miniImg;
  }
  
  var authorElem = document.createElement('p');
      authorElem.className = "photoAuthor"
      authorElem.innerHTML = "par <em>"+author+"</em>";
  elem.appendChild(authorElem);
}

function addAllGallery() {
  createZoomElem();
  
  var elems = document.getElementsByClassName('gallery');
  var it1;
  var it1_max = elems.length;
  for(it1=0; it1<it1_max;it1++) {
    var gal_id   = elems[it1].getAttribute("data-id");
    var nb_img   = elems[it1].getAttribute("data-nb-img");
    if (elems[it1].hasAttribute("data-nb-mini")) {
      var nb_mini  = elems[it1].getAttribute("data-nb-mini");}
    else {
      var nb_mini  = elems[it1].getAttribute("data-nb-img");
    }
    var name     = elems[it1].getAttribute("data-name");
    var author   = elems[it1].getAttribute("data-author");
    var url      = 'galleries/'+gal_id+'/';
    addGalery2(elems[it1]);
  }
  addEvent(document.getElementById('zoom'), 'click', checkOutZoomBox2);
  addEvent(window, 'resize', resizeZoom2);
  addEvent(window, 'scroll', resizeZoom2);
  addEvent(document.getElementById('zoomImg'), 'load', resizeZoom2);
}

function createZoomElem() {
  if(document.getElementById('zoom')) {
    var oldZoom = document.getElementById('zoom')
    oldZoom.parentNode.removeChild(oldZoom);
  }
  var zoomElem = document.createElement('div');
  zoomElem.id = "zoom";

  var closeElem = document.createElement('a');
  closeElem.id = "closeZoom";
  closeElem.src = "#";
  closeElem.onclick = hideZoom2;
  closeElem.innerHTML = "Close";
  zoomElem.appendChild(closeElem);
  
  var prevElem = document.createElement('a');
  prevElem.id = "linkPrevImg";
  prevElem.src = "#";
  prevElem.onclick = prevImg2;
  prevElem.innerHTML = "Prev";
  zoomElem.appendChild(prevElem);
  
  var imgElem = document.createElement('img');
  imgElem.id = "zoomImg";
  imgElem.src = "";
  imgElem.onclick = nextImg2;
  zoomElem.appendChild(imgElem);
  
  var nextElem = document.createElement('a');
  nextElem.id = "linkNextImg";
  nextElem.src = "#";
  nextElem.onclick = nextImg2;
  nextElem.innerHTML = "Next";
  zoomElem.appendChild(nextElem);
  
  document.body.appendChild(zoomElem);
}
var gallery = {};
addAllGallery();