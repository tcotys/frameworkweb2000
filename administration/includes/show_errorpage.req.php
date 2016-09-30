<?php
  function showBasicAdminHTML($inside_txt = "", $siteName = "") {
    if (function_exists('getBackPath')) {
      $backPath = getBackPath();
    }
    else {
      require_once(dirname(__File__).DIRECTORY_SEPARATOR.'get_site_paths.req.php');
      $backPath = getBackPath();
    }
    if (function_exists('getsitename') && $siteName = "") {
      $siteName = getsitename();
    }
    
    ?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>Administration du site <?php echo $siteName; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo getBackPath();?>style.css">
  </head>
  <body>

   <header id="articles_menu">
      <h1 class="unnumbered"><?php echo $siteName; ?></h1>
      <h2 class="unnumbered">Administration</h2>
      <nav>
        <ul>
          <li><a href="<?php echo getBackPath(); ?>index.php">Main menu</a></li>
        </ul>
      </nav>
    </header>
    
    <section class="blockdisplay">
      <h1>Website error</h1>
      <article>
        <?php echo $inside_txt; ?>
      </article>
    </section>
  </body>
</html>
    <?php
  }  
?>
