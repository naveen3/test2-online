<?php
// $Id$

/**
 * @file
 * Default theme implementation to display a dynamic display blocks from a dynamic display block instance.
 *
 * Available variables:
 * - $origin: Original module of the block.
 * - $delta: Block number of the block.
 * - $pager: Pager type to add the dynamic display block.
 * - $pager_height: Pager container height.
 * - $pager_width: Pager container width.
 * - $imgcache_pager_item: Image cache preset name for the pager item.
 * - $content: themed content.
 *
 * notes: don't change the following ID's and class names, they are used by the jQuery script to show dynamic display blocks.
 *  <div id="ddblock-<?php print $delta; ?>" - for the whole block
 *  <div class="ddblock-content clear-block"> - for the dimension of the block
 *  <div class="ddblock-container"> - for the container of the slides
 *  <div id="ddblock-<?php print $pager ."-". $delta ?>" - for the number pager
 *  <ul id="ddblock-<?php print $pager ."-". $delta ?>" - for the image pager
 *  <li> - for the items of the image pager
 *  <div id="ddblock-<?php print $pager ."-". $delta ?>" - for the prev next pager
 */
?>
<!-- block content. -->

<div id="ddblock-<?php print $delta; ?>" class="ddblock-contents clear-block" style="visibility:hidden">
  <div class="ddblock-content clear-block">
  <div class="featured-top-corner pngfix"><img src="<?php print base_path(). path_to_theme() ?>/images/featured-top-corner.png" height="5" width="940" /></div>
  <div class="featured-bottom-corner pngfix"><img src="<?php print base_path(). path_to_theme() ?>/images/featured-bottom-corner.png" height="5" width="940" /></div>
    <!-- Adding play and pause button -->
    <?php if (($pager == 'number-pager')): ?>
    <!-- number pager. -->
    <div id="ddblock-<?php print $pager ."-". $delta ?>" class="ddblock-<?php print $pager ?> ddblock-pager clear-block" style="height: <?php print $pager_height ?>px; width:<?php print $pager_width ?>px;"> <span id="pause-cycle">pause</span> <span id="resume-cycle">play</span>
      <!-- End - Adding play and pause button -->
    </div>
    <?php endif; ?>
    <?php if (($pager == 'image-pager')): ?>
    <!-- image pager. -->
    <ul id="ddblock-<?php print $pager ."-". $delta ?>" class="ddblock-<?php print $pager ?> ddblock-pager clear-block" style="height: <?php print $pager_height ?>px; width:<?php print $pager_width ?>px;">
      <?php if($imgcache_pager_item != '<none>'):?>
      <?php foreach ($content as $image_file): ?>
      <li> <a href="#" title="click to navigate to topic"> <?php print theme('imagecache', $imgcache_pager_item, $image_file); ?> </a> </li>
      <?php endforeach; ?>
      <?php else :?>
      <?php foreach ($content as $image_file): ?>
      <li> <a href="#" title="click to navigate to topic"><img src="<?php print base_path() . $image_file; ?>" alt="" width="55" height="55" /></a> </li>
      <?php endforeach; ?>
      <?php endif;?>
    </ul>
    <?php endif; ?>
    <?php if ($pager == 'prev-next-pager'): ?>
    <!-- prev next pager. -->
    <div id="ddblock-<?php print $pager ."-". $delta ?>" class="ddblock-<?php print $pager ?> ddblock-pager clear-block" style="height: <?php print $pager_height ?>px; width:<?php print $pager_width ?>px;"> <a id="prev2" href="#">Previous</a> <a id="next2" href="#">Next</a> </div>
    <?php endif; ?>
    <?php if ($output_type == 'images') : ?>
    <div class="ddblock-container">
      <?php if($imgcache_slide != '<none>'):?>
      <?php foreach ($content as $image_file): ?>
      <?php print theme('imagecache', $imgcache_slide, $image_file); ?>
      <?php endforeach; ?>
      <?php else :?>
      <?php foreach ($content as $image_file): ?>
      <img src="<?php print base_path() . $image_file; ?>" alt="" width="55px" height="55px" />
      <?php endforeach; ?>
      <?php endif;?>
    </div>
    <?php endif; ?>
    <?php if ($output_type == 'content_array') : ?>
    <div class="ddblock-container">
      <?php foreach ($content as $item): ?>
      <?php print($item); ?>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ($output_type == 'view_content') : ?>
    <div class="ddblock-container"> <?php print($content); ?> </div>
    <?php endif; ?>
  </div>
</div>
