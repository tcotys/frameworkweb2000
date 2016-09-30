<script>
  function addHtmlVideoButton(elem, textarea_prefix)
  {
    var vid_list_li = document.createElement('li');
    var vid_list_a  = document.createElement('a');
    vid_list_a.innerHTML = "Videos";
    vid_list_a.href = "#";
    var vid_list_ul = document.createElement('ul');
    <?php   
      $rep9 = $bdd->query('SELECT * FROM '.getTablePrefix().'videos');
      while ($don9 = $rep9->fetch()){
        ?>
          var button_elem = document.createElement('a');
              button_elem.href = "#";
              button_elem.innerHTML =  "<?php echo $don9['name']; ?>";
              button_elem.setAttribute("data-id", "<?php echo $don9['id']; ?>");
              button_elem.setAttribute("data-name", "<?php echo $don9['name']; ?>");
              button_elem.setAttribute("data-width", "<?php echo $don9['width']; ?>");
              button_elem.setAttribute("data-height", "<?php echo $don9['height']; ?>");
              button_elem.setAttribute("data-type", "<?php echo $don9['type']; ?>");
              button_elem.setAttribute("data-source", "<?php echo $don9['source']; ?>");
              button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
              button_elem.onclick = addVideoInHtmlCode;
          var li_elem = document.createElement('li');
          li_elem.appendChild(button_elem);
          vid_list_ul.appendChild(li_elem);
        <?php
      }
      $rep9->closeCursor();
    ?>
    vid_list_li.appendChild(vid_list_a);
    vid_list_li.appendChild(vid_list_ul);
    elem.appendChild(vid_list_li);
  }

  function addVideoInHtmlCode(e) {
    var ev              = e || window.event;
    var target          = ev.target || ev.srcElement;
    var id              = target.getAttribute("data-id");
    var name            = target.getAttribute("data-name");
    var width           = target.getAttribute("data-width");
    var height          = target.getAttribute("data-height");
    var type            = target.getAttribute("data-type");
    var source          = target.getAttribute("data-source");
    var textarea_prefix = target.getAttribute("data-textarea-prefix");
  //   var init_markup  = '<div title="Video: '+name+'" id="video'+id+'"\n';
  //       init_markup += ' style="background-image:url(\'videos/'+id+'.jpg\');background-position:center;background-repeat:no-repeat;\n';
  //       init_markup += ' width:'+width+'px;height:'+height+'px;vertical-align:middle;text-align:center;display:table-cell;"\n';
  //       init_markup += '    onclick="launchVideo(\''+id+'\', \''+name+'\', \''+width+'\', \''+height+'\', \''+type+'\', \''+source+'\');return false;">\n';
  //       init_markup += '  <img src="images/play.png" id="plays1"\n    onclick="launchVideo(\''+id+'\', \''+name+'\', \''+width+'\', \''+height+'\', \''+type+'\', \''+source+'\');return false;" />\n';
  //       init_markup += '</div>';
    var init_markup  = '<div title="Video: '+name+'" class="videos_plugin" data-id="'+id+'" data-name="'+name+'"';
        init_markup += '   data-width="'+width+'" data-height="'+height+'" data-type="'+type+'" data-source="'+source+'"></div>';
    var end_marlup = '';
    addMarkup(init_markup, end_marlup, textarea_prefix);
    return false;
  }
</script>