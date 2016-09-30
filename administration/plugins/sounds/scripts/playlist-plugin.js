function findPos(el)
{
 var x = 0,
     y = 0;
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

function parseIntArray(array_in) {
  var it1, len = array_in.length;
  for(it1 = 0; it1 < len; it1++) {
    array_in[it1] = parseInt(array_in[it1]);
  }
  return array_in;
}

function getPlstFromElem(elem) {
  var it1         = 1;
  while (parseInt(elem.id.substr(6, it1)) == elem.id.substr(6, it1)) {
    it1++;
  }
  return parseInt(elem.id.substr(6, it1-1));
}

</script>
<script type="text/javascript"
src="../sounds/soundmanagerv297a-20140901/script/soundmanager2.js"></script>
<script type="text/javascript">
// ------------------------------------------------- //
// ----- Player MP3 : Initialisation du player ----- //
// ------------------------------------------------- //



function create_playlist() {
  var all_lists = document.getElementsByTagName('OL');
  var nb_lists = all_lists.length;
  var it1, it2, tracklist = [];
  tracklist['active_playlist'] = 0;
  tracklist['volume']          = 100;
  tracklist['muted']           = 0;
  
  for(it1 = 0; it1 < nb_lists; it1++) {
    if(all_lists[it1].className == "tracklist") {
      var ul_elem                               = all_lists[it1];
      var playlist_id                           = parseInt(ul_elem.id.substr(6,ul_elem.id.length-15));
      tracklist[playlist_id]                    = [];
      tracklist[playlist_id]['id']              = playlist_id;
      tracklist[playlist_id]['tracklist']       = [];
      tracklist[playlist_id]['active_track']    = 0;
      tracklist[playlist_id]['loadbar_clicked'] = 0;
      tracklist[playlist_id]['timeline_width']  = document.getElementById('player'+playlist_id+'-timeline').offsetWidth;
      tracklist[playlist_id]['slider_width']    = 0;
      tracklist[playlist_id]['slider_pos_min']  = 0;
      if(tracklist['active_playlist'] == 0) {
        tracklist['active_playlist']            = playlist_id;
      }
      if(document.getElementById('player'+playlist_id+'-timeline')) {
        var timeline_elem = document.getElementById('player'+playlist_id+'-timeline');
        timeline_elem.onmousedown = move_slider_mousedown;
        timeline_elem.onclick     = move_slider_mousedown;
      }

      
      var li_elems                              = ul_elem.getElementsByTagName('LI');
      var nb_li_elems                           = li_elems.length;
      for(it2 = 0; it2 < nb_li_elems; it2++) {
        var li_elem = li_elems[it2];
        if(li_elem.className = "track") {
          var track_id    = li_elem.getAttribute('data-id');
          var track_url   = li_elem.getAttribute('data-url');
          var track_cover = li_elem.getAttribute('data-cover');
          var a_elem  = li_elem.getElementsByTagName('A');
          var track_name  = a_elem[0].innerHTML;
          tracklist[playlist_id]['tracklist'].push(track_id);
          tracklist[playlist_id][track_id]                   = [];
          tracklist[playlist_id][track_id]['id']             = parseInt(track_id);
          tracklist[playlist_id][track_id]['name']           = track_name;
          tracklist[playlist_id][track_id]['cover']          = track_cover;
          tracklist[playlist_id][track_id]['url']            = track_url;
          tracklist[playlist_id][track_id]['total_duration'] = 1;
          if(tracklist[playlist_id]['active_track'] == 0) {
            tracklist[playlist_id]['active_track']    = parseInt(track_id);
          }
        }
      }
    }
  }

  document.onmouseup   = move_slider_mouseup;
  document.onmousemove = move_slider_mousemove;
  return tracklist;
}
var playlist = create_playlist();
updatePlayer();

window.onresize = function() {
  var all_lists = document.getElementsByTagName('OL');
  var nb_lists = all_lists.length;
  var it1;
  for(it1 = 0; it1 < nb_lists; it1++) {
    if(all_lists[it1].className == "tracklist") {
      var ul_elem     = all_lists[it1];
      var playlist_id = parseInt(ul_elem.id.substr(6,ul_elem.id.length-15));
      playlist[playlist_id]['timeline_width']  = document.getElementById('player'+playlist_id+'-timeline').offsetWidth;
    }
  }
  updatePlayer();
};
 
function updatePlayer() {
  for(var player_id in playlist) {
    if(player_id == parseInt(player_id)) {
      var track_id  = playlist[player_id]['active_track'];
      var it1;
      document.getElementById('player'+player_id+'-cover').src = playlist[player_id][track_id]['cover'];
      for (it1 in playlist[player_id]) {
        if(parseInt(it1) == it1) {
          document.getElementById('player'+player_id+'-track'+it1).className = 'track';
        }
      }
      document.getElementById('player'+player_id+'-track'+track_id).className = 'track played';
      document.getElementById('player'+player_id+'-songtitle').innerHTML =
playlist[player_id][track_id]['name'];
      if(playlist['muted']) {
        document.getElementById('player'+player_id+'-volume').className = 'button volume vol_mute';
      }
      else if(playlist['volume'] < 1) {
        document.getElementById('player'+player_id+'-volume').className = 'button volume vol_mute';
      }
      else if(playlist['volume'] < 35) {
        document.getElementById('player'+player_id+'-volume').className = 'button volume vol_low';
      }
      else if(playlist['volume'] > 65) {
        document.getElementById('player'+player_id+'-volume').className = 'button volume vol_high';
      }
      else {
        document.getElementById('player'+player_id+'-volume').className = 'button volume vol_mid';
      }
    }
  }
}
      
function newSliderPosition(relative_position) { // en pourcent 
  var playlist_id = playlist['active_playlist'];
  var sliderPositionMin = playlist[playlist_id]['slider_pos_min'],
      sliderWidth       = playlist[playlist_id]['slider_width'],
      timelineWidth     = playlist[playlist_id]['timeline_width'];
      
  var sliderPositionMax = sliderPositionMin + timelineWidth - sliderWidth;
  var sliderPosition = sliderPositionMin + Math.round((timelineWidth - sliderWidth) *
relative_position);
  if (sliderPosition < sliderPositionMin) {
    sliderPosition = sliderPositionMin;}
  if (sliderPosition > sliderPositionMax) {
    sliderPosition = sliderPositionMax;}
  document.getElementById('player'+playlist_id+'-slider').style.left = sliderPosition+"px";
}
      
function resetLoadbar() {
  var song_id =
'player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'];
  var bytesLoaded = soundManager.getSoundById(song_id).bytesLoaded;
  var bytesTotal  = soundManager.getSoundById(song_id).bytesTotal;
  var timelineWidth = playlist[playlist['active_playlist']]['timeline_width'];
  document.getElementById('player'+playlist['active_playlist']+'-loadbar').style.width =
bytesLoaded/bytesTotal*timelineWidth + "px";
}

function changeSong(track_id, playlist_id){
  if(playlist_id != parseInt(playlist_id)) {
    playlist_id = playlist['active_playlist'];
  }
  if(track_id != parseInt(track_id)) {
    track_id = playlist[playlist_id]['active_track'];
  }
  
  playlist['active_playlist'] = playlist_id;
  playlist[playlist_id]['active_track']    = track_id;
  updatePlayer();
  soundManager.play('player'+playlist_id+'track'+track_id);
  resetLoadbar();
  soundManager.setVolume('player'+playlist_id+'track'+track_id, playlist['volume']);
}

soundManager.setup({
  url:  '../sounds/soundmanagerv297a-20140901/swf/',
  waitForWindowLoad: true,
  preferFlash: false,
//  flashLoadTimeout: 0,// msec to wait for flash movie to load before failing (0 = infinity) 
  useHTML5Audio: true,
//  debugFlash:true, // met une case en flash qui imprime la console de d�bugage
  html5Test: /^(probably|maybe)$/i, // HTML5 Audio() format support test. 
                          // Use /^probably$/i; if you want to be more conservative.
  debugMode : false,
//  consoleOnly: false,
  onready: function() {
    var it1, it2;
    for(it1 in playlist) {
      if(parseInt(it1) == it1) {
        var nb_track = playlist[it1]['tracklist'].length;
        for(it2 in playlist[it1]) {
          if(parseInt(it2) == it2) {
            var track_pos                = playlist[it1]['tracklist'].indexOf(it2);
            var next_pos                 = (track_pos < (nb_track-1))?(track_pos+1):(0)
            var next_track               = playlist[it1]['tracklist'][next_pos];
            var prev_pos                 = (track_pos > 0)?(track_pos-1):(nb_track-1)
            var prev_track               = playlist[it1]['tracklist'][prev_pos];
            playlist[it1][it2]['next']   = parseInt(next_track);
            playlist[it1][it2]['prev']   = parseInt(prev_track);
            
            soundManager.createSound({
              id : 'player'+it1+'track'+it2,
              url : playlist[it1][it2]['url'], 
              onplay : function() {
                document.getElementById('player'+playlist['active_playlist']+'-play').style.display
= "none";
                document.getElementById('player'+playlist['active_playlist']+'-pause').style.display
= "inline-block";
                if(this.loaded){
                  var timelineWidth = playlist[playlist['active_playlist']]['timeline_width'];
                 
document.getElementById('player'+playlist['active_playlist']+'-loadbar').style.width = timelineWidth
+ "px";
                  playlist[playlist['active_playlist']]['total_duration'] = this.duration;
                  var total_duration = playlist[playlist['active_playlist']]['total_duration'];
                  var minutes = parseInt(total_duration/60000);
                  var seconds = parseInt((total_duration%60000)/1000);
                      seconds = ((seconds<10)?('0'):('')) + seconds;
                 
document.getElementById('player'+playlist['active_playlist']+'-duration').innerHTML  =
minutes+':'+seconds;
                }
              },
              onstop : function() {
                document.getElementById('player'+playlist['active_playlist']+'-play').style.display
= "inline-block";
                document.getElementById('player'+playlist['active_playlist']+'-pause').style.display
= "none";
              },
              onpause : function() {
                document.getElementById('player'+playlist['active_playlist']+'-play').style.display
= "inline-block";
                document.getElementById('player'+playlist['active_playlist']+'-pause').style.display
= "none";
              },
              onresume : function() {
                document.getElementById('player'+playlist['active_playlist']+'-play').style.display
= "none";
                document.getElementById('player'+playlist['active_playlist']+'-pause').style.display
= "inline-block";
              },
              whileloading : function() {
                playlist[playlist['active_playlist']]['total_duration'] = this.durationEstimate;
                var total_duration = playlist[playlist['active_playlist']]['total_duration'];
                var minutes = parseInt(total_duration/60000);
                var seconds = parseInt((total_duration%60000)/1000);
                    seconds = ((seconds<10)?('0'):('')) + seconds;
                var timelineWidth = playlist[playlist['active_playlist']]['timeline_width'];
                document.getElementById('player'+playlist['active_playlist']+'-duration').innerHTML
 = minutes+':'+seconds;
                document.getElementById('player'+playlist['active_playlist']+'-loadbar').style.width
= this.bytesLoaded/this.bytesTotal*timelineWidth + "px";
              },
              onload : function() {
                playlist[playlist['active_playlist']]['total_duration'] = this.duration;
                var total_duration = playlist[playlist['active_playlist']]['total_duration'];
                var minutes = parseInt(total_duration/60000);
                var seconds = parseInt((total_duration%60000)/1000);
                    seconds = ((seconds<10)?('0'):('')) + seconds;
                var timelineWidth = playlist[playlist['active_playlist']]['timeline_width'];
                document.getElementById('player'+playlist['active_playlist']+'-duration').innerHTML
 = minutes+':'+seconds;
                document.getElementById('player'+playlist['active_playlist']+'-loadbar').style.width
= timelineWidth + "px";
              },
              whileplaying : function() {
                var total_duration = playlist[playlist['active_playlist']]['total_duration'];
                var relative_position =  this.position/total_duration;
                newSliderPosition(relative_position);
                
                var minutes = parseInt(this.position/60000);
                var seconds = parseInt((this.position%60000)/1000);
                    seconds = ((seconds<10)?('0'):('')) + seconds;
                document.getElementById('player'+playlist['active_playlist']+'-position').innerHTML
 = minutes+':'+seconds;
              },
              onbeforefinish :  function() {
                var next_track =
playlist[playlist['active_playlist']][playlist[playlist['active_playlist']]['active_track']]['next'];
               
soundManager.getSoundById('player'+playlist['active_playlist']+'track'+next_track).load();
              },
              onfinish : player_next
            });
          }
        }
      }
    }
  },
  ontimeout: function() {
    alert('Erreur dans le chargement du lecteur mp3');
  }  
});

function player_play(track_id, playlist_id) {
  var change_track = 1;
  if(parseInt(playlist_id) != playlist_id) {
    playlist_id = playlist['active_playlist'];
  }
  if(parseInt(track_id) != track_id) {
    track_id = playlist[playlist_id]['active_track'];
    change_track = 0;
  }
  if(change_track || playlist['active_playlist'] != playlist_id) {
    var song_id =
'player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'];
    soundManager.pause(song_id);
//     soundManager.stop(song_id);
//     soundManager.unload(song_id);
  }
  changeSong(track_id, playlist_id);
}

function player_pause(playlist_id) {
  if(parseInt(playlist_id) != playlist_id) {
    playlist_id = playlist['active_playlist'];
  }
  soundManager.pause('player'+playlist_id+'track'+playlist[playlist_id]['active_track']);
}

function player_stop(playlist_id) {
  if(parseInt(playlist_id) != playlist_id) {
    playlist_id = playlist['active_playlist'];
  }
  var song_id = 'player'+playlist_id+'track'+playlist[playlist_id]['active_track'];
  soundManager.stop(song_id);
  soundManager.unload(song_id);
}

function player_next(playlist_id) {
  if(parseInt(playlist_id) != playlist_id) {
    playlist_id = playlist['active_playlist'];
  }
  var song_id =
'player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'];
  if(playlist_id ==  playlist['active_playlist']) {
    soundManager.stop(song_id);
    soundManager.unload(song_id);
  }
  else {
    soundManager.pause(song_id);
  }
  var next_track = playlist[playlist_id][playlist[playlist_id]['active_track']]['next'];
  changeSong(next_track,playlist_id);
}

function player_prev(playlist_id) {
  if(parseInt(playlist_id) != playlist_id) {
    playlist_id = playlist['active_playlist'];
  }
  var song_id =
'player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'];
  if (soundManager.getSoundById(song_id).position < 4000) {
    if(playlist_id ==  playlist['active_playlist']) {
      soundManager.stop(song_id);
      soundManager.unload(song_id);
    }
    else {
      soundManager.pause(song_id);
    }
    var prev_track = playlist[playlist_id][playlist[playlist_id]['active_track']]['prev'];
    changeSong(prev_track, playlist_id);
  }
  else {
   
soundManager.setPosition('player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'],
0);
  }
}

function player_vol_plus() {
  var song_id =
'player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'];
  if(playlist['volume'] < 91) {
    playlist['volume'] += 10;
    soundManager.setVolume(song_id, playlist['volume']);
    playlist['volume'] = playlist['volume'];
    updatePlayer();
  }
  if(playlist['muted']) {
    soundManager.unmute(song_id);
    playlist['muted'] = 0;
  }
}

function player_vol_less() {
  var song_id =
'player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'];
  if(playlist['volume'] > 9) {
    playlist['volume'] -= 10;
    soundManager.setVolume(song_id, playlist['volume']);
    playlist['volume'] = playlist['volume'];
  }
  if(playlist['muted']) {
    soundManager.unmute(song_id);
    playlist['muted'] = 0;
  }
  updatePlayer();
}


function player_mute() {
  var song_id =
'player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'];
  if(playlist['muted']) {
    soundManager.unmute(song_id);
    playlist['muted'] = 0;
  }
  else {
    soundManager.mute(song_id);
    playlist['muted'] = 1;
  }
  updatePlayer();
}

function player_move(newPosition, playlist_id) {
  if(playlist_id != parseInt(playlist_id)) {
    playlist_id = playlist['active_playlist'];
  }
  if (playlist_id != playlist['active_playlist']) {
    changeSong(playlist[playlist_id]['tracklist'][0], playlist_id);
  }
  var song_id =
'player'+playlist['active_playlist']+'track'+playlist[playlist['active_playlist']]['active_track'];
  var total_duration = soundManager.getSoundById(song_id).duration;
  soundManager.setPosition(song_id, Math.round(newPosition*total_duration));
}

function move_slider_mousedown(e) {
  var ev = e || window.event;
  if (ev.preventDefault) {
    ev.preventDefault();}
  ev.returnValue  = false;
  var elem        = ev.target;
  var playlist_id = getPlstFromElem(elem);
  
  if(ev.type != 'click') {playlist[playlist_id]['clicked'] = true;}
  var pos                   = findPos(elem);
  var mousePos              = getMousePos(ev);
  var diffx                 = mousePos.x - pos.x;
  var sliderPositionMin     = playlist[playlist_id]['slider_pos_min'],
      sliderWidth           = playlist[playlist_id]['slider_width'],
      timelineWidth         = playlist[playlist_id]['timeline_width'];
  
  var xMin                  = sliderPositionMin+sliderWidth/2,
      xMax                  = sliderPositionMin+timelineWidth-sliderWidth/2;
  if(diffx > xMin && diffx < xMax)  {
    var newPositionRelative = (diffx-xMin)/(xMax-xMin);
    player_move(newPositionRelative, playlist_id);
  }
};

function move_slider_mousemove(e) {
  if (playlist[playlist['active_playlist']]['clicked']) {
    var ev = e || window.event;
    var elem = document.getElementById('player'+playlist['active_playlist']+'-timeline');
    
    var sliderPositionMin = playlist[playlist['active_playlist']]['slider_pos_min'],
        sliderWidth       = playlist[playlist['active_playlist']]['slider_width'],
        timelineWidth     = playlist[playlist['active_playlist']]['timeline_width'];
    
    var pos = findPos(elem);
    var mousePos = getMousePos(ev);
    var diffx = mousePos.x - pos.x;
    var xMin = sliderPositionMin+sliderWidth/2, xMax = sliderPositionMin+timelineWidth-sliderWidth/2;
    if(diffx > xMin && diffx < xMax)  {
      var newPositionRelative = (diffx-xMin)/(xMax-xMin);
      player_move(newPositionRelative);
    }
  }
};

function move_slider_mouseup() {
  playlist[playlist['active_playlist']]['clicked'] = false;
}
