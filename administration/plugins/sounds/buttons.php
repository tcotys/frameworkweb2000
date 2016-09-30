<script>
  function addHtmlPlaylistButton(elem, textarea_prefix)
  {
    var sounds_list_li = document.createElement('li');
    var sounds_list_a  = document.createElement('a');
    sounds_list_a.innerHTML = "Playlists";
    sounds_list_a.href = "#";
    var sounds_list_ul = document.createElement('ul');
    <?php

      
      $rep11 = $bdd->query('SELECT * FROM '.getTablePrefix().'sounds_playlists ORDER BY id');
      while ($don11 = $rep11->fetch()){
        ?>
          var button_elem = document.createElement('a');
              button_elem.href = "#";
              button_elem.innerHTML =  "<?php echo $don11['name']; ?>";
              button_elem.setAttribute("data-id",              "<?php echo $don11['id'];     ?>");
              button_elem.setAttribute("data-name",            "<?php echo $don11['name'];   ?>");
              button_elem.setAttribute("data-style",           "<?php echo $don11['style'];  ?>");
              button_elem.setAttribute("data-tracklist",       "<?php echo $don11['tracks']; ?>");
              button_elem.setAttribute("data-textarea-prefix", textarea_prefix                  );
              button_elem.onclick = addPlaylistInHtmlCode;
          var li_elem = document.createElement('li');
          li_elem.appendChild(button_elem);
          sounds_list_ul.appendChild(li_elem);
        <?php
      }
      $rep11->closeCursor();
    ?>
    sounds_list_li.appendChild(sounds_list_a);
    sounds_list_li.appendChild(sounds_list_ul);
    elem.appendChild(sounds_list_li);
  }
  
  function addPlaylistInHtmlCode(e) {
    var ev              = e || window.event;
    var target          = ev.target || ev.srcElement;
    var id              = target.getAttribute("data-id");
    var name            = target.getAttribute("data-name");
    var style           = target.getAttribute("data-style");
    var tracklist       = target.getAttribute("data-tracklist").split('.');
    var textarea_prefix = target.getAttribute("data-textarea-prefix");
    
    var init_markup = '\n'
      + '<div class="soundplayer" id="player'+id+'">\n'
      + '  <img class="playercover" id="player'+id+'-cover" src="sounds/no-cover.png" />\n'
      + '  <span class="songtitle"><h3 class="songtitle-text" id="player'+id+'-songtitle"></h3></span>\n'
      + '  <div class="playercontroler" id="player'+id+'-controller">\n'
      + '    <div class="player-volumebox">\n'
      + '      <a    id="player'+id+'-volume"   class="button volume vol_high" href="#" onclick="player_mute(); return false;" >MUTE</a>\n'
      + '      <a    id="player'+id+'-vol-plus" class="button volume_plus"     href="#" onclick="player_vol_plus(); return false;" >PLUS</a>\n'
      + '      <a    id="player'+id+'-vol-less" class="button volume_less"     href="#" onclick="player_vol_less(); return false;" >PLUS</a>\n'
      + '    </div>\n'
      + '    <div class="player-basicbox">\n'
      + '      <a    id="player'+id+'-prev"     class="button prev"            href="#" onclick="player_prev('+id+'); return false;" >PREV</a>\n'
      + '      <a    id="player'+id+'-play"     class="button play"            href="#" onclick="player_play(\'a\','+id+'); return false;" >PLAY</a>\n'
      + '      <a    id="player'+id+'-pause"    class="button pause"           href="#" onclick="player_pause('+id+'); return false;">PAUSE</a>\n'
      + '      <a    id="player'+id+'-stop"     class="button stop"            href="#" onclick="player_stop('+id+'); return false;">STOP</a>\n'
      + '      <a    id="player'+id+'-next"     class="button next"            href="#" onclick="player_next('+id+');return false;" >NEXT</a>\n'
      + '    </div>\n'
      + '    <div  id="player'+id+'-timeline" class="button timeline">\n'
      + '      <span id="player'+id+'-loadbar" class="loadbar"></span>\n'
      + '      <a id="player'+id+'-slider" class="slider" href="#slider">SLIDER</a>\n'
      + '    </div>\n'
      + '    <div class="player-timetexts">\n'
      + '      <span id="player'+id+'-position" class="playerposition"         >0:00</span>\n'
      + '      <span id="player'+id+'-duration" class="playerduration"         >0:00</span>\n'
      + '    </div>\n'
      + '  </div>\n'
      + '\n'
      + '  <ol class="tracklist" id="player'+id+'-tracklist" data-id="'+id+'">\n';
    if(tracklist[0] == 0){
      alert("Sorry, this playlist doesn't contains any track..."); 
      return false;
    }
    for(track_id in tracklist) {
      var track_info = all_tracks_info[parseInt(tracklist[track_id])];
//       console.log(all_tracks_info);
//       console.log(track_info);
      if(track_info['artist'] == '') {
        var track_name = track_info['title'];
      }
      else {
        var track_name = track_info['artist']+' - '+track_info['title'];
      }
      init_markup += 
          '    <li id="player'+id+'-track'+track_info['id']+'" class="track" data-id="'+track_info['id']+'" data-url="'+track_info['url']+'" data-cover="'+track_info['cover']+'">\n'
        + '      <a href="#" onclick="player_play('+track_info['id']+','+id+'); return false;">'+track_name+'</a>\n'
        + '    </li>\n'
    }  
    init_markup += 
        '  </ol>\n'
      + '</div>\n';

    var end_marlup = '';
    addMarkup(init_markup, end_marlup, textarea_prefix);
    return false;
  }
  
  var all_tracks_info = { 
<?php
    $first_elem = 1;
    $rep12 = $bdd->query('SELECT * FROM '.getTablePrefix().'sounds_tracks ORDER BY id');
    while($don12 = $rep12->fetch()) {
      $track_url = "";
      if($don12['type'] == 'local') {
        $track_url = 'sounds/'.$don12['id'].'.'.$don12['source'];
      }
      elseif($don12['type'] == 'url') {
        $track_url = $don12['source'];
      }
      
      if(in_array($don12['cover_type'], array('jpg', 'png', 'gif'))) {
        $cover_url = 'sounds/'.$don12['id'].'.'.$don12['cover_type'];
      }
      else {
        $cover_url = 'sounds/no-cover.png';
      }
      
      if($track_url != "") {
        if(!$first_elem) {echo ",\n";}
        $first_elem = 0;
        echo '
        '.$don12['id'].':{
          id    :'.$don12['id'].',
          title :"'.$don12['name'].'",
          artist:"'.$don12['author'].'",
          cover :"'.$cover_url.'",
          url   :"'.$track_url.'"}';
      }
    }
    $rep12->closeCursor();
  ?>}   
</script>
