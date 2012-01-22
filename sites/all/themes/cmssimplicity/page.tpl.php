<?php
// $Id$
/**
 * @file
 *
 * Theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $css: An array of CSS files for the current page.
 * - $directory: The directory the theme is located in, e.g. themes/garland or
 *   themes/garland/minelli.
 * - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Page metadata:
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $body_classes: A set of CSS classes for the BODY tag. This contains flags
 *   indicating the current layout (multiple columns, single column), the current
 *   path, whether the user is logged in, and so on.
 * - $body_classes_array: An array of the body classes. This is easier to
 *   manipulate then the string in $body_classes.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $search_box: HTML to display the search box, empty if search has been disabled.
 * - $primary_links (array): An array containing primary navigation links for the
 *   site, if they have been configured.
 * - $secondary_links (array): An array containing secondary navigation links for
 *   the site, if they have been configured.
 *
 * Page content (in order of occurrance in the default page.tpl.php):
 * - $header1: The HTML for the region - Header 1.
 * - $header2: The HTML for the region - Header 2.
 * - $header3: The HTML for the region - Header 3.
 * - $navbar: The HTML for the region - Navigation bar.
 * - $content_top1: The HTML for the region - Content top 1.
 * - $content_top2: The HTML for the region - Content top 2.
 * - $content_top3: The HTML for the region - Content top 3.
 * - $content_top4: The HTML for the region - Content top 4.
 * - $content_top5: The HTML for the region - Content top 5.
 * - $content_bottom1: The HTML for the region - Content bottom 1.
 * - $content_bottom2: The HTML for the region - Content bottom 2.
 * - $content_bottom3: The HTML for the region - Content bottom 3.
 * - $right: The HTML for the right sidebar.
 * - $right_sidebar2: The HTML for the right sidebar 2.
 * - $breadcrumb: The breadcrumb trail for the current page.
 * - $title: The page title, for use in the actual HTML content.
 * - $help: Dynamic help text, mostly for admin pages.
 * - $messages: HTML for status and error messages. Should be displayed prominently.
 * - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the view
 *   and edit tabs when displaying a node).
 *
 * - $content: The main content of the current Drupal page.
 *
 * - $right: The HTML for the right sidebar.
 *
 * Some other data(related to css) depending on theme-settings:
 * - $body_text_font: Font family for body text.
 * - $heading_text_font: Font family for header text.
 * - $sidebar_left_width : Left sidebar width.
 * - $width_sidebar_right : Right sidebar width.
 * - $width_sidebar_right2: Right sidebar 2 width.
 * - $width_content_body: Middle body content width.
 *
 * Footer/closing data:
 * - $feed_icons: A string of all feed icons for the current page.
 * - $footer_message: The footer message as defined in the admin settings.
 * - $footer : The footer region.
 * - $footer2 : The footer 2 region.
 * - $closure: Final closing markup from any modules that have altered the page.
 *   This variable should always be output last, after all other dynamic content.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 */


/**
 * Fluid sidebar ID's:
 *  Left Sidebar: #sidebar-left
 *  Right Sidebar: #sidebar-right
 *  Right sidebar2: #sidebar-right2
 *  Content in between sidebars: #content-body
 * Font ID's:
 *  Body fonts: body
 *  Header fonts: h1, h2, h3, h4, h5, h6, #site-name, #site-slogan
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
<title><?php print $head_title; ?></title>
<?php print $head; ?><?php print $styles; ?><?php print $scripts; ?>
<style type="text/css">
<?php if (!theme_get_setting('use_css_for_fonts')) : ?> body, .comment h3.title {
font-family : <?php print $body_text_font;
?>;
}
h1, h2, h3, h4, h5, h6, #navigation, #site-name, #site-slogan {
font-family : <?php print $heading_text_font;
?>;
}
 <?php endif;
?> #sidebar-left {
width:<?php print $sidebar_left_width;
?>px;
}
#sidebar-right {
width:<?php print $width_sidebar_right;
?>px;
}
#sidebar-right2 {
width:<?php print $width_sidebar_right2;
?>px;
}
#content-body {
width:<?php print $width_content_body;
?>px;
}
</style>
</head>
<body class="<?php print $body_classes; ?>">
<div id="main-wrapper">
<div id="wrapper">
  <div id="wrapper-inner">
   <div id="wrapper-sub-inner">
    <div id="header-wrapper" class="grid_full">
      <?php if ($header1): ?>
      <div id="header1" class="header1">
        <div class="inner"> <?php print $header1; ?> </div>
      </div>
      <?php endif; ?>
      <div id="header-middle" class="clearall grid_full">
        <div id="header-middle-inner">
          <?php if ($logo || $site_name || $site_slogan): ?>
          <div id="logo-title">
            <?php if ($logo): ?>
            <div id="logo" class="logo"> <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"> <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" id="logo-image" height="<?php print $logo_size[1];?>" width="<?php print $logo_size[0];?>" /> </a> </div>
            <?php endif; ?>
            <div id="site-name-slogan">
              <?php if ($site_name): ?>
              <div id="site-name"> <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"> <?php print $site_name; ?> </a> </div>
              <?php endif; ?>
              <?php if ($site_slogan): ?>
              <div id="site-slogan"> <?php print $site_slogan; ?> </div>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>
          <?php if ($header2 || $header3): ?>
          <div id="header-2-3-container" class="floatr">
            <?php if ($header2): ?>
            <div id="header2">
              <div class="inner"> <?php print $header2; ?> </div>
            </div>
            <?php endif; ?>
            <?php if ($header3): ?>
            <div id="header3" >
              <div class="inner"> <?php print $header3; ?> </div>
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div id="main">
      <div id="main-inner" >
        <div id="content">
        <div class="white-corner-top"><div class="white-corner-topright pngfix">&nbsp;</div></div>
          <div id="content-inner">
            <?php if ($breadcrumb || $messages || $help): ?>
            <div id="top-text">
              <div class="inner">
                <?php if ($breadcrumb): print $breadcrumb; endif; ?>
                <?php if ($messages || $help): print $messages; print $help; endif; ?>
              </div>
            </div>
            <?php endif; ?>
            <?php if ($content_top1): ?>
            <div id="content-top1" class="clearall">
              <div class="inner"> <?php print $content_top1; ?> </div>
            </div>
            <?php endif; ?>
            <?php if ($content_top2 || $content_top3): ?>
            <div id="content-2-3" class="clearall">
              <?php if ($content_top3): ?>
              <div id="content-top3" class="<?php print $content_top3_class;?>">
                <div class="inner"> <?php print $content_top3; ?> </div>
              </div>
              <?php endif; ?>
              <?php if ($content_top2): ?>
              <div id="content-top2" class="<?php print $content_top2_class;?>">
                <div class="inner"> <?php print $content_top2; ?> </div>
              </div>
              <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($content_top4): ?>
            <div id="content-top4" class="clearall">
              <div id="content-top4-inner"><div id="content-top4-sub-inner"><?php print $content_top4; ?></div></div>
            </div>
            <?php endif; ?>
            <div id="content-body-wrapper-inner" >
              <?php if ($left): ?>
              <div id="sidebar-left">
                <div class="inner"> <?php print $left; ?> </div>
              </div>
              <?php endif; ?>
              <div id="content-body">
                <div id="content-body-inner">
                  <?php if ( $title || $tabs  || $content): ?>
                  <?php if ($content_top5): ?>
                  <div id="content-top5">
                    <div class="inner"> <?php print $content_top5; ?> </div>
                  </div>
                  <?php endif; ?>
                  <?php if ($title || $tabs): ?>
                  <div id="content-header">
                    <?php if ($title): ?>
                    <h1 class="title"><?php print $title; ?></h1>
                    <?php endif; ?>
                    <?php if ($tabs): ?>
                    <div class="tabs"> <?php print $tabs; ?> </div>
                    <?php endif; ?>
                  </div>
                  <?php endif; ?>
                  <div id="main-content"><?php print $content; ?></div>
                  <?php if ($content_bottom1): ?>
                  <div id="content-bottom1">
                    <div class="inner"> <?php print $content_bottom1; ?> </div>
                  </div>
                  <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
              <?php if ($right): ?>
              <div id="sidebar-right">
                <div class="inner"> <?php print $right; ?> </div>
              </div>
              <?php endif; ?>
              <?php if ($right_sidebar2): ?>
              <div id="sidebar-right2">
                <div class="inner"> <?php print $right_sidebar2; ?> </div>
              </div>
              <?php endif; ?>
            </div>
            <?php if ($content_bottom2): ?>
            <div id="content-bottom2" class="clearall">
              <div class="inner"> <?php print $content_bottom2; ?> </div>
            </div>
            <?php endif; ?>
            <?php if ($content_bottom3): ?>
            <div id="content-bottom3" class="clearall">
              <div id="content-bottom3-inner"><div id="content-bottom3-sub-inner"><?php print $content_bottom3 ?></div></div>
            </div>
            <?php endif; ?>
          </div>
        <div class="white-corner-bottom"><div class="white-corner-bottomright">&nbsp;</div></div>
        </div>
        <!-- /#content-inner, /#content -->
        <div id="navigation">
          <div class="inner"> <?php print $navbar; ?> </div>
        </div>
        <!-- /#navbar-inner, /#navbar -->
      </div>
    </div>
    <?php if ($footer || $footer_message || $footer2): ?>
    <div id="footer">
      <?php if ($footer): ?>
      <div id="footer1">
        <div class="inner"> <?php print $footer; ?> </div>
      </div>
      <?php endif; ?>
      <?php if ($footer2): ?>
      <div id="footer2">
        <div class="inner"> <?php print $footer2; ?> </div>
      </div>
      <?php endif; ?>
        <div id="cmsquickstart" >
        <div class="inner"> <a href="http://www.cmsquickstart.com">Drupal Themes by CMS Quick Start</a> </div>
      </div>
      <?php if ($footer_message): ?>
      <div id="footer-message">
        <div class="inner"> <?php print $footer_message; ?> </div>
      </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
</div>
</div>
</div>
<?php print $closure; ?>
</body>
</html>