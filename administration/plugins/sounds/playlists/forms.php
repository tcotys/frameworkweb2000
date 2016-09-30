<script type="text/javascript"> 
  function showNewPlaylistForm() {
    var out_box = '';
    out_box += '<h2>Creating playlist</h2>\n';
    out_box += '<p>\n';
    out_box += '  <form method=post action="<?php echo getBackPath(); ?>plugins/sounds/playlists/new.php">\n';
    out_box += '    <label for="playlist_name">Name : <input type="text" name="name" id="playlist_name" value="" /></label><br />\n';
    out_box += '    <label for=playlist_design">Design : <input type="text" name="style" id="playlist_design" value="default" /></label><br />\n'
    out_box += '    <input type=submit value="Create" />\n';
    out_box += '  </form>\n';
    out_box += '</p>\n';
    openDialogBox('newPlaylistForm', out_box);
    refreshScrollOnForms();
  }
  function deletePlaylist(redirection, nomFichier) {
    var params = {'playlist_id':redirection};
    var addr   = '<?php echo getBackPath(); ?>plugins/sounds/playlists/delete.php';
    var text   = 'la playlist : ' + nomFichier
    askDelete(addr, params, text);
  }

  function showEditPlaylistForm(id, name, design, tracks) {
    var id_prefix = 'playlist'+id;
    var out_txt = '';
    out_txt += '<h2>Edition de playlist</h2>';
    out_txt += '<form method="post" action="<?php echo getBackPath(); ?>plugins/sounds/playlists/edit.php">';
    out_txt += '  <label for="'+id_prefix+'name">Name : </label>';
    out_txt += '  <input type="text" id="'+id_prefix+'name" name="name" value="'+name+'" /><br />';
    out_txt += '  <label for="'+id_prefix+'design">Design : </label>';
    out_txt += '  <input type="text" id="'+id_prefix+'design" name="design" value="'+design+'" /><br />';
    
    out_txt += '  <ul class="track_menu_list" id="'+id_prefix+'all_tracks"></ul>';
    out_txt += '  <span class="track_add_del_buttons">';
    out_txt += '    <input type="button" value=">>" onclick="addToPlaylist(\''+id_prefix+'\'); return false;" data-prefix="'+id_prefix+'" /><br />';
    out_txt += '    <input type="button" value="<<" onclick="delFromPlaylist(\''+id_prefix+'\'); return false;" data-prefix="'+id_prefix+'" />';
    out_txt += '  </span>';
    out_txt += '  <ul class="track_menu_list" id="'+id_prefix+'playlist_tracks"></ul><br />';
    
    out_txt += '  <input type="hidden" name="tracks" value="'+tracks+'" id="'+id_prefix+'tracks" />';
    out_txt += '  <input type="hidden" name="playlist_id" value="'+id+'" />';
    out_txt += '  <input type="submit" value="Save" />';
    out_txt += '</form>';
    var it3;
    var tracks_array = tracks.split(".");
    for(it3 in tracks_array) {
      tracks_array[it3] = parseInt(tracks_array[it3]);
    }
    playlist_tracks[id_prefix] = tracks_array;
    
    openDialogBox('editGalleryForm'+id, out_txt);
    refreshTracksMenu(id_prefix);
    refreshScrollOnForms();
  }
  
  
  var playlist_tracks = [];
  
  var all_tracks_info = { 
      0:{
        id:0,
        name:"not a song",
        author:"",
        selected:0}, <?php
    $first_elem = 1;
    $rep12 = $bdd->query('SELECT * FROM '.getTablePrefix().'sounds_tracks ORDER BY id');
    while($don12 = $rep12->fetch()) {
      if(!$first_elem) {echo ",\n";}
      $first_elem = 0;
      echo '
      '.$don12['id'].':{
        id:'.$don12['id'].',
        name:"'.$don12['name'].'",
        author:"'.$don12['author'].'",
        selected:0}';
    }
    $rep12->closeCursor();
  ?>}   
        
  function refreshTracksMenu(id_prefix) {
    var all_tracks_elem            = document.getElementById(id_prefix+'all_tracks');
    var playlist_tracks_elem       = document.getElementById(id_prefix+'playlist_tracks');
    all_tracks_elem.innerHTML      = "";
    playlist_tracks_elem.innerHTML = "";
    
    var it1, it2;
    for(it1 in all_tracks_info) {
      if(it1 > 0) {
        var track_info = all_tracks_info[it1];
        if(playlist_tracks[id_prefix].indexOf(parseInt(track_info["id"])) == -1) {
          createTrackElem(track_info, all_tracks_elem, id_prefix);
        }
      }
    }
    for(it2 in playlist_tracks[id_prefix]) {
      if(playlist_tracks[id_prefix][it2] > 0) { 
        var track_info = all_tracks_info[playlist_tracks[id_prefix][it2]];
        createTrackElem(track_info, playlist_tracks_elem, id_prefix, 1);
      }
    }
    
    document.getElementById(id_prefix+'tracks').value = playlist_tracks[id_prefix].join(".");
  }
  
  function createTrackElem(track_info, parent_elem, id_prefix, setUpDown) {
    var li_elem = document.createElement('li');
    li_elem.innerHTML = track_info["name"];
    li_elem.setAttribute("data-id", track_info["id"]);
    li_elem.setAttribute("data-prefix", id_prefix);
    if(track_info["selected"] == 1) {
      li_elem.className = "sel_track";
    }
    li_elem.onclick = selectTrack;
    if(setUpDown == 1) {
      var span_elem = document.createElement("span");
      var a1_elem   = document.createElement("a");
      a1_elem.href = "#";
      a1_elem.onclick = moveUpInPlaylist;
      a1_elem.innerHTML = "up";
      a1_elem.setAttribute("data-id", track_info["id"]);
      a1_elem.setAttribute("data-prefix", id_prefix);
      a1_elem.className = "tracklist_up_button";
      span_elem.appendChild(a1_elem);
      
      var a2_elem   = document.createElement("a");
      a2_elem.href = "#";
      a2_elem.onclick = moveDownInPlaylist;
      a2_elem.innerHTML = "down";
      a2_elem.setAttribute("data-id", track_info["id"]);
      a2_elem.setAttribute("data-prefix", id_prefix);
      a2_elem.className = "tracklist_down_button";
      span_elem.appendChild(a2_elem);
      li_elem.appendChild(span_elem);
    }
    
    parent_elem.appendChild(li_elem);
  }
  
  function selectTrack(e) {
    var ev        = e || window.event;
    var target    = ev.target || ev.srcElement;
    var id_prefix = target.getAttribute("data-prefix");
    if(target.nodeName == "LI") {
      var track_id = target.getAttribute("data-id");
      
      all_tracks_info[track_id].selected = Math.abs(all_tracks_info[track_id].selected-1);
      refreshTracksMenu(id_prefix);
    }
  }
  
  function addToPlaylist(id_prefix) {
//       function addToPlaylist(e) {
//         var ev = e || window.event;
//         var target = ev.target || ev.srcElement;
//         var id_prefix = target.getAttribute("data-prefix");
    var it1;
    for(it1 in all_tracks_info) {
      var track_info = all_tracks_info[it1]
      if(track_info["selected"] == 1) {
        if(playlist_tracks[id_prefix].indexOf(track_info["id"]) == -1) {
          playlist_tracks[id_prefix].push(track_info["id"]);
          all_tracks_info[it1]["selected"] = 0;
        }
      }
    }
    refreshTracksMenu(id_prefix);
  }
  
  
  function delFromPlaylist(id_prefix) {
//       function delFromPlaylist(e) {
//         var ev = e || window.event;
//         var target = ev.target || ev.srcElement;
//         var id_prefix = target.getAttribute("data-prefix");
    var it1;
    for(it1 in all_tracks_info) {
      var track_info = all_tracks_info[it1]
      if(track_info["selected"] == 1) {
        var track_pos = playlist_tracks[id_prefix].indexOf(track_info["id"]);
        if(track_pos != -1) {
          playlist_tracks[id_prefix].splice(track_pos, 1);
          all_tracks_info[it1]["selected"] = 0;
        }
      }
    }
    refreshTracksMenu(id_prefix);
  }
  
  function moveUpInPlaylist(e) {
    var ev = e || window.event;
    var target = ev.target || ev.srcElement;
    var track_id = parseInt(target.getAttribute("data-id"));
    var id_prefix = target.getAttribute("data-prefix");
    var track_pos = playlist_tracks[id_prefix].indexOf(track_id);
    if(track_pos != -1 && track_pos != 0) {
      playlist_tracks[id_prefix].splice(track_pos, 1);
      playlist_tracks[id_prefix].splice(track_pos-1, 0, track_id);
    }
    refreshTracksMenu(id_prefix);
    return false;
  }
  
  function moveDownInPlaylist(e) {
    var ev = e || window.event;
    var target = ev.target || ev.srcElement;
    var track_id = parseInt(target.getAttribute("data-id"));
    var id_prefix = target.getAttribute("data-prefix");
    var track_pos = playlist_tracks[id_prefix].indexOf(track_id);
    if(track_pos != -1 && track_pos != (playlist_tracks.length-1)) {
      playlist_tracks[id_prefix].splice(track_pos, 1);
      playlist_tracks[id_prefix].splice(track_pos+1, 0, track_id);
    }
    refreshTracksMenu(id_prefix);
    return false;
  }
      
</script>

<style>
  ul.track_menu_list {
    display:inline-block;
    width:200px;
    height:200px;
    border:1px solid black;
    padding:0px;
    margin-top:0px;
    margin-bottom:0px;
    vertical-align:top;
    background-color:white;
    overflow:scroll;
    overflow-x:hidden;
    resize:both;
    cursor:default;
  }
  ul.track_menu_list li {
    list-style-type: none;
    list-style-position: inside;
    position:relative;
    padding-left:5px;
    padding-right:5px;
/*         overflow:hidden; */
    white-space:nowrap;
    -o-text-overflow:ellipsis;
    text-overflow:ellipsis;
  }
  ul.track_menu_list li:hover {
    background-color:lightgrey;
  }
  ul.track_menu_list li.sel_track {
    background-color:grey;
  }
  
  ul.track_menu_list li span {
    display:none;
    position:absolute;
    top:0px;
    right:0px;
    background-color:white;
    height: 16px;
    width: 40px;
  }
  ul.track_menu_list li:hover span {
    display:block;
  }
  
  .track_add_del_buttons {
    display:inline-block;
    vertical-align:top;
  }
  .tracklist_up_button {
    display:inline-block;
    height:16px;
    width:16px;
    font-size:0%;
    background-image:url('../sounds/buttons/arrow-up-16.png');
    position:absolute;
    left:2px;
  }
  .tracklist_down_button {
    display:inline-block;
    height:16px;
    width:16px;
    font-size:0%;
    background-image:url('../sounds/buttons/arrow-down-16.png');
    position:absolute;
    left:22px;
  }
</style>