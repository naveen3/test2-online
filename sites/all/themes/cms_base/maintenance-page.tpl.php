<?php
// $Id$

/**
 * @file
 * Theme implementation to display a single Drupal page while off-line.
 *
 * All the available variables are mirrored in page.tpl.php. Some may be left
 * blank but they are provided for consistency.
 *
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">

<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $scripts; ?> 
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyled Content in IE */ ?> </script>
  <link href="<?php print base_path(). path_to_theme() ?>/css/maintenance.css" rel="stylesheet" type="text/css" />
</head>
<body class="<?php print $body_classes; ?>">
<div id="maintenance_wrapper">
<h1>We are currently offline for maintenance</h1>
<div class="description"> <?php print $content; ?></div>
</div>
</div>

</body>
</html>
