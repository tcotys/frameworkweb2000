<?php
  include_once('includes/libraries_includer.inc.php');
  if(isset($_SESSION['message'])) {
    $save_message = preg_replace('/\s+/', ' ', trim(addslashes($_SESSION['message'])));
    $_SESSION['message'] = '';
  }
  else {
    $save_message = '';
  }
  if(isset($_SESSION['script'])) {
    $load_script = $_SESSION['script'];
    $_SESSION['script'] = '';
  }
  else {
    $load_script = '';
  }
  if(isset($_SESSION['anchored_page'])) {
    $anchored_page = $_SESSION['anchored_page'];
  }
  else {
    $_SESSION['anchored_page'] = 'local_pages_article';
    $anchored_page = 'local_pages_article';
  }
  
  // ----- initialisation des plugins ----- //
  include_once("includes/plugins_loader.inc.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>Administration du site <?php echo getSiteName(); ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <header id="articles_menu">
      <h1 class="unnumbered"><?php echo getSiteName(); ?></h1>
      <h2 class="unnumbered">Administration</h2>
      <nav>
        <ul>
        <?php
          foreach($PluginsInfo as $plugin) {
            if($plugin['mysql_installed']) {
              if($plugin['menu_type'] == 'text') {
                if ($plugin['section_id_type'] == 'text') {
                  echo "<li><a href=\"#".$plugin['section_id']."\">".$plugin['menu']."</a></li>\n";
                }
                else {
                  echo "<li>".$plugin['menu']."</li>\n";
                }
              }
              elseif ($plugin['menu_type'] == 'texts') {
                if($plugin['section_id_type'] == 'texts' and sizeof($plugin['section_id']) == sizeof($plugin['menu']) ){
                  foreach($plugin['menu'] as $elem_id => $plugin_menu) {
                  echo "<li><a href=\"#".$plugin['section_id'][$elem_id]."\">".$plugin_menu."</a></li>\n";
                  }
                }
                else { 
                  foreach($plugin['menu'] as $plugin_menu) {
                    echo "<li>".$plugin_menu."</li>\n";
                  }
                }
              }
              elseif ($plugin['menu_type'] == 'file') {
                echo "<li>";
                include $plugin['menu'];
                echo "</li>\n";
              }
              elseif ($plugin['menu_type'] == 'files') {
                foreach($plugin['menu'] as $plugin_menu) {
                  echo "<li>";
                  include $plugin_menu;
                  echo "</li>\n";
                } 
              }
            }
          }
        ?>
        </ul>
      </nav>
    </header>
    
    <?php
      foreach($PluginsInfo as $plugin) {
        if($plugin['mysql_installed']) {
          if($plugin['list_type'] == 'text') {
            echo $plugin['list'];
          }
          elseif ($plugin['list_type'] == 'file') {
            include $plugin['list'];
          }
          elseif ($plugin['list_type'] == 'files') {
            foreach($plugin['list'] as $plugin_list) {
              include $plugin_list;
            } 
          }
        }
      }
    ?>
    
    <script type="text/javascript" src="javascript/dialogBoxes.js"></script>
    <script type="text/javascript" src="javascript/scrollOnForms.js"></script>
    <script type="text/javascript" src="javascript/askDelete.js"></script>
    <?php
      foreach($PluginsInfo as $plugin) {
        if($plugin['mysql_installed']) {
          if($plugin['forms_type'] == 'text') {
            echo $plugin['forms'];
          }
          elseif ($plugin['forms_type'] == 'file') {
            include $plugin['forms'];
          }
          elseif ($plugin['forms_type'] == 'files') {
            foreach($plugin['forms'] as $plugin_list) {
              include $plugin_list;
            } 
          }
        }
      }
    ?>
    <script type="text/javascript">
      // ----- Delete pages and images ----- //
      function getFolder() {
        var localFolder = window.location.href;
        if (~localFolder.indexOf('index')) { //~x fait -(x+1)
          localFolder  = localFolder.substring(0, localFolder.indexOf('index.php'));
        }
        if (~localFolder.indexOf('#')) { //~x fait -(x+1)
          localFolder  = localFolder.substring(0, localFolder.indexOf('#'));
        }
        return localFolder;
      }
          

      // ----- show message from treaded forms ----- //
      function showSaveMessage() {
        var saveMessageText = '<?php echo $save_message; ?>';
        if (saveMessageText != '') {
          var saveMessageEnd = '<p><input type="button" value="Fermer" onclick="closeDialogBox(\'save_message\');" /></p>';
          openDialogBox('save_message', saveMessageText + saveMessageEnd);
          refreshScrollOnForms();
        }
      }
      
      // ----- Script launch while loading the page ---- //
      <?php
        if (isset($_SESSION['scrollInfo'])) {
          $scrollInfo = $_SESSION['scrollInfo'];
        }
        else {
          $scrollInfo = 0;
        }
      ?>
      window.scrollTo(0,<?php echo $scrollInfo;?>);
      <?php echo $load_script; ?>
      showSaveMessage();
      // ----- Design in order to highlight selected link ----- //
      if (location.hash == "") {
        location.hash = "<?php echo $anchored_page; ?>";
      }
      function updateSelectedTab() {
        var it2;
        var oldSelectedTab = document.getElementsByTagName("li");
        for(it2 = 0; it2 < oldSelectedTab.length; it2++) {
          oldSelectedTab[it2].className = oldSelectedTab[it2].className.replace(/selectedTab/i, "");
        }
          
        var nav_links = document.getElementsByTagName("a");
        var it1;
        for (it1 = 0; it1 < nav_links.length; it1++) {
          link_anchor = nav_links[it1].href.split("#");
          link_anchor = '#' + link_anchor[link_anchor.length - 1];
          if (link_anchor  == location.hash) {
            nav_links[it1].parentNode.className = nav_links[it1].className + " selectedTab";
          }
        }
      }
      
      updateSelectedTab();
      if ("onhashchange" in window) { // event supported? : Google Chrome 5, Safari 5, Opera 10.60, Firefox 3.6 and Internet Explorer 8
        window.onhashchange = function () {
//           hashChanged(window.location.hash);
          updateSelectedTab();
        }
      }
      else { // event not supported:
        var storedHash = window.location.hash;
        window.setInterval(function () {
          if (window.location.hash != storedHash) {
            storedHash = window.location.hash;
//             hashChanged(storedHash);
            updateSelectedTab();
          }
        }, 100);
      }
    </script>
  </body>
</html>
