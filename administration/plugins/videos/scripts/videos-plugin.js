</script>
<link href="videos/video-js/video-js.css" rel="stylesheet">
<script src="videos/video-js/video.js"></script>
<script src="videos/video-js/youtube.js"></script>
<script>
videojs.options.flash.swf = "videos/video-js/video-js.swf"


function launchVideo(e) {
  var ev = e || window.event;
  var target = ev.target || ev.srcElement;
  while (target.className != 'videos_plugin') {
    target = target.parentNode;
  }
  var videoDiv = target;

  var vid_id   = videoDiv.getAttribute("data-id");
  var name     = videoDiv.getAttribute("data-name");
  var width    = videoDiv.getAttribute("data-width");
  var height   = videoDiv.getAttribute("data-height");
  var type     = videoDiv.getAttribute("data-type");
  var source   = videoDiv.getAttribute("data-source");

  videoDiv.innerHTML = "";
  videoDiv.onclick = "";
  var videoElem = document.createElement('video');
  videoElem.id = "inVid"+vid_id;
  videoElem.className = "video-js vjs-default-skin";

  var params = {"controls": true, "autoplay": true, "preload": "auto"};
  if(type == "youtube") {
    params.techOrder = ["youtube"];
    params.src = source;
    params.ytcontrols = "true";
  }
  else if (type == "local") {
    var it1;
    var source_ext  = source.split(".");
    var it1_max = source_ext.length;
    for(it1 = 0; it1 < it1_max; it1++) {
      var sourceElem = document.createElement('source');
      sourceElem.type = 'video/'+source_ext[it1];
      sourceElem.src  = 'videos/'+vid_id+'.'+source_ext[it1];
      videoElem.appendChild(sourceElem);
    }
  }
  params.width  = width+"px";
  params.height = height+"px";
  
  videoDiv.appendChild(videoElem);
  videojs("inVid"+vid_id, params);
}

function addAllVideos() {
  var elems = document.getElementsByClassName('videos_plugin');
  var play_button = []
  var it1;
  var it1_max = elems.length;
  for(it1=0; it1<it1_max;it1++) {
    var id       = elems[it1].getAttribute("data-id");
    var name     = elems[it1].getAttribute("data-name");
    var width    = elems[it1].getAttribute("data-width");
    var height   = elems[it1].getAttribute("data-height");
    var type     = elems[it1].getAttribute("data-type");
    var source   = elems[it1].getAttribute("data-source");
    
    elems[it1].title                 = "Videos: "+name;
    elems[it1].style.backgroundImage = 'url("videos/'+id+'.jpg")';
    elems[it1].style.width           = width+'px';
    elems[it1].style.height          = height+'px';
    elems[it1].onclick               = launchVideo;

    play_button[it1]       = document.createElement('img');
    play_button[it1].src       = "images/play.png";
    play_button[it1].className = "videoPlayButton";
    play_button[it1].onclick   = launchVideo;
    
    elems[it1].appendChild(play_button[it1]);
  }
}
addAllVideos();