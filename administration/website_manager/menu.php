<section id="website_manager_article">
  <h1>Plugin manager</h2>
  <article>
    <p>
      <a href="#" onclick="showEditMainParameters(); return false;" class="button website_params">Website parameters</a>
      <a href="#" onclick="showNewPluginUpload(); return false;" class="button add">Add plugin</a>
    <ul>
    <?php
      foreach($PluginsInfo as $plugin_id => $plugin) {
        echo '<li class="has_mini"><span class="img_name">'.$plugin['name'].'</span>';
        if($plugin['mysql_installed']) {
          ?>
            <a href="#" onclick="return false;" class="button mysql_ok">MySQL</a>
          <?php
        }
        else {
          ?>
            <a href="#" onclick="document.getElementById('plugin_manager_create_mysql_<?php echo $plugin_id;?>').submit(); return false;" class="button mysql_ko" style="color:red;">MySQL</a>
            <form method="post" action="website_manager/mysql_tables/edit.php" id="plugin_manager_create_mysql_<?php echo $plugin_id;?>">
              <input type="hidden" name="plugin_id" value="<?php echo $plugin_id; ?>" />
              <input type="hidden" name="check"     value="<?php echo urlencode($PluginsInfo[$plugin_id]['name']); ?>" />
            </form>
          <?php
        }
      }
    ?>
    </ul>
    <p>
      <a href="#" onclick="showEditMainParameters(); return false;" class="button website_params">Website parameters</a>
      <a href="#" onclick="showNewPluginUpload(); return false;" class="button add">Add plugin</a>
    <ul>
  </article>
</section>
