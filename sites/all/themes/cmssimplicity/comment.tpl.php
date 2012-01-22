<?php
// $Id$

/**
 * @file
 * Theme implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: Body of the post.
 * - $date: Date and time of posting.
 * - $links: Various operational links.
 * - $new: New comment marker.
 * - $picture: Authors picture.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $submitted: By line with date and time.
 * - $title: Linked title.
 * - $classes: A set of CSS classes for the comment container div.
 *
 * These two variables are provided for context.
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * @see template_preprocess_comment()
 * @see theme_comment()
 */
?>
<div class="comment <?php print $classes; ?> clearfix">

  <?php if ($picture || $submitted || $title || $new): ?>
  <div class="meta clearfix">

    <?php if ($comment->new): ?>
      <span class="new"><?php print $new ?></span>
    <?php endif; ?>

    <?php print $picture ?>

    <?php if ($submitted): ?>
    <span class="submitted">
      <?php print $submitted ?>
    </span>
    <?php endif; ?>
    <h3 class="title"><?php print $title ?></h3>
  </div>
  <?php endif; ?>

  <div class="content clearfix comment-content">
  <span class="arrow">&nbsp;</span>
    <?php print $content ?>
    <?php if ($signature): ?>
      <div class="user-signature clear-block">
        <?php print $signature ?>
      </div>
    <?php endif; ?>
    <?php print $links ?>
  </div>
</div>
