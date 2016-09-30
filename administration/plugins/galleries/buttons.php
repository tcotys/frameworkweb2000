<script>
  function addHtmlGalleryButton(elem, textarea_prefix)
  {
    var gal_list_li = document.createElement('li');
    var gal_list_a  = document.createElement('a');
    gal_list_a.innerHTML = "Galleries";
    gal_list_a.href = "#";
    var gal_list_ul = document.createElement('ul');
    <?php   
      $rep10 = $bdd->query('SELECT * FROM '.getTablePrefix().'galleries');
      while ($don10 = $rep10->fetch()){
        ?>
          var button_elem = document.createElement('a');
              button_elem.href = "#";
              button_elem.innerHTML =  "<?php echo $don10['name']; ?>";
              button_elem.setAttribute("data-id", "<?php echo $don10['id']; ?>");
              button_elem.setAttribute("data-name", "<?php echo $don10['name']; ?>");
              button_elem.setAttribute("data-author", "<?php echo $don10['author']; ?>");
              button_elem.setAttribute("data-nb-img", "<?php echo $don10['nb_img']; ?>");
              button_elem.setAttribute("data-textarea-prefix", textarea_prefix);
              button_elem.onclick = addGalleryInHtmlCode;
          var li_elem = document.createElement('li');
          li_elem.appendChild(button_elem);
          gal_list_ul.appendChild(li_elem);
        <?php
      }
      $rep10->closeCursor();
    ?>
    gal_list_li.appendChild(gal_list_a);
    gal_list_li.appendChild(gal_list_ul);
    elem.appendChild(gal_list_li);
  }

  function addGalleryInHtmlCode(e) {
    var ev = e || window.event;
    var target = ev.target || ev.srcElement;
    var id = target.getAttribute("data-id");
    var name = target.getAttribute("data-name");
    var author = target.getAttribute("data-author");
    var nb_img = target.getAttribute("data-nb-img");
    var textarea_prefix = target.getAttribute("data-textarea-prefix");
    var init_markup  = '<article id="gallery'+id+'" class="gallery"';
        init_markup += ' data-id="'+id+'"';
        init_markup += ' data-name="'+name+'"';
        init_markup += ' data-author="'+author+'"';
        init_markup += ' data-nb-img="'+nb_img+'"></article>';
    var end_marlup = '';
    addMarkup(init_markup, end_marlup, textarea_prefix);
    return false;
  }
</script>