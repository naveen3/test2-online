<?php
// $Id$

/**
 * @file
 * Contains helper functions for preprocessor functions. 
 */



/**
 * Overrides or inserts variables into the node templates.
 *
 * Auto-rebuilds the theme registry during theme development if it is enabled from theme settings.
 */
function _cms_base_initialize() {
  if (theme_get_setting('rebuild_registry')) {
    drupal_rebuild_theme_registry();
    drupal_set_message(t('The theme registry has been rebuilt. <a href="!url">Turn off</a> this feature on production websites.', array('!url' => url('admin/build/themes/settings/'. $GLOBALS['theme']))), 'warning');
  }
}


/**
 * helper  function for cmsbase_theme() preprocess function
 * computes the conditional style sheets and loads the default theme settings
 * @param $existing 
 *   An array of existing implementations(call by reference).
 * @param $type 
 *   What 'type' is being processed
 * @param $theme 
 *   The name of theme
 * @param $path 
 *   The directory path of the theme
 * @return  
 *   A blank array(nothing)
 */
function _cms_base_theme(&$existing, $type, $theme, $path) {
  
  include_once './'. drupal_get_path('theme', 'cms_base') .'/theme-settings.inc';
  // Computes the conditional stylesheets.
  if (!module_exists('conditional_styles')) {
    include_once './'. drupal_get_path('theme', 'cms_base') .'/conditional-styles.inc';
    if ($theme == 'cms_base') {
      _conditional_styles_theme($existing, $type, $theme, $path);
    }
  }

  // Since we are rebuilding the theme registry and the theme settings' default
  // values may have changed, make sure they are saved in the database properly.
  cms_base_default_settings($theme);

  return array();
}


/**
 * Creates block edit links for privileged users.
 * @param $block 
 *   Current block object
 * @return  
 *   An array of block editing links
 */
function _cms_base_block_editing_links($block) {
  $destination = drupal_get_destination();
  if ($block->module == 'block') { 
    $edit_links[] = array( 
      'title'           => t('edit block'),
      'url'             => 'admin/build/block/configure/'. $block->module .'/'. $block->delta,
      'attributes'      => array('title' => t('edit the content of this block'), 'class' => 'block-edit'),
      'query'           => $destination,
    );  
  }
  else {
    $edit_links[] = array( 
      'title'           => t('configure'),
      'url'             => 'admin/build/block/configure/'. $block->module .'/'. $block->delta,
      'attributes'      => array('title' => t('configure this block'), 'class' => 'block-edit'),
      'query'           => $destination,
    );  
  }
    // Displays 'edit view link' for Views blocks.
  if ($block->module == 'views' && user_access('administer views')) {
    list($view_name, $view_block) = explode('-block', $block->delta);
    $edit_links[] = array( 
      'title'           => t('edit view'),
      'url'             => 'admin/build/views/edit/'. $view_name,
      'attributes'      => array('title' => t('cedit the view that defines this block'), 'class' => 'block-edit-view'),
      'fragment'        => 'views-tab-block'. $view_block,
      'query'           => $destination,
    );  
  }
  // Displays 'edit menu' for Menu blocks.
  if (user_access('administer menu') && ($block->module == 'menu' || ($block->module == 'user' && $block->delta == 1))) {
      $menu_name = ($block->module == 'user') ? 'navigation' : $block->delta;
      $edit_links[] = array( 
        'title'         => t('edit menu'),
        'url'           => 'admin/build/menu-customize/'. $menu_name,
        'attributes'    => array('title' => t('edit the menu that defines this block'), 'class' => 'block-edit-menu'),
        'query'        => $destination,
      );  
    }
  if (user_access('administer menu') && $block->module == 'menu_block') {
      list($menu_name, ) = split(':', variable_get("menu_block_{$block->delta}_parent", 'navigation:0'));    
      $edit_links[] = array( 
        'title'         => t('edit menu'),
        'url'           => 'admin/build/menu-customize/'. $menu_name,
        'attributes'    => array('title' => t('edit the menu that defines this block'), 'class' => 'block-edit-menu'),
        'query'         => $destination,
      );  
    }
  return $edit_links;
}


/**
 * Show/Hide the node subbmitted data from node depending on theme-settings.
 * @param $node 
 *   Current node object.
 * @return 
 *   The 'submitted by' text. 
 */
function _cms_node_submitted_by_text($node) {
  $posted_date = t('Posted on ') . format_date($node->created, 'medium'); 
  $author = theme('username', $node);
  $author_separator = t('Posted by ');
  $date_separator = t(' by ');
  $submitted_by_content_type = (theme_get_setting('submitted_by_content_type') == 1) ? $node->type : 'default';
  $date_setting = (theme_get_setting('submitted_by_date_'. $submitted_by_content_type) == 1);
  $author_setting = (theme_get_setting('submitted_by_author_'. $submitted_by_content_type) == 1);
  $author_separator = ($date_setting) ? $date_separator : $author_separator;
  $date_author = ($date_setting) ? $posted_date : '';
  $date_author .= ($author_setting) ? $author_separator . $author : '';
  return $date_author;
}

/**
 * Formats the term listing depending on theme-settings.
 * @param $vars 
 *   An array of variables to pass to the theme template.
 * @return 
 *   Formatted list of terms. 
 */
function _cms_base_node_term_list($vars) {
  $taxonomy_content_type = (theme_get_setting('taxonomy_enable_content_type') == 1) ? $vars['node']->type : 'default';
  $taxonomy_display = theme_get_setting('taxonomy_display_'. $taxonomy_content_type);
  $taxonomy_format = theme_get_setting('taxonomy_format_'. $taxonomy_content_type);
  if ($taxonomy_display == 'all' || ($taxonomy_display == 'only' && $vars['page'])) {
    $vocabularies = taxonomy_get_vocabularies($vars['node']->type);
    $output = '';
    $term_delimiter = ', ';
    foreach ($vocabularies as $vocabulary) {
      if (theme_get_setting('taxonomy_vocab_hide_'. $taxonomy_content_type .'_'. $vocabulary->vid) != 1) {
        $terms = taxonomy_node_get_terms_by_vocabulary($vars['node'], $vocabulary->vid);
        if ($terms) {
          $term_items = '';
          foreach ($terms as $term) {                        // Build vocabulary term items
            $term_link = l($term->name, taxonomy_term_path($term), array('attributes' => array('rel' => 'tag', 'title' => strip_tags($term->description))));
            $term_items .= '<li class="vocab-term">'. $term_link . $term_delimiter .'</li>';
          }
          if ($taxonomy_format == 'vocab') {                 // Add vocabulary labels if separate
            $output .= '<li class="vocab vocab-'. $vocabulary->vid .'"><span class="vocab-name">'. $vocabulary->name .':</span> <ul class="vocab-list">';
            $output .= substr_replace($term_items, '</li>', -(drupal_strlen($term_delimiter) + 5)) .'</ul></li>';
          }
          else {
            $output .= $term_items;
          }
        }
      }
    }
    if ($output != '') {
      $output = ($taxonomy_format == 'list') ? substr_replace($output, '</li>', -(drupal_strlen($term_delimiter) + 5)) : $output;
      $output = '<ul class="taxonomy">'. $output .'</ul>';
    }
    return $output;
  }
}

/**
 * Formats the node links depending on theme-settings.
 * @param $vars 
 *   An array of variables to pass to the theme template.
 * @param $link_name 
 *   name of the link for which formatting is to be setup.
 * @return 
 *   array of node links. 
 */
function _cms_base_node_links($vars, $link_name) {
  switch ($link_name) {
    case 'node_read_more' :
      $node_content_type = (theme_get_setting('readmore_content_type') == 1) ? $vars['node']->type : 'default';
      $pre_prefix  =  'readmore_';
      $url = 'node/'. $vars['node']->nid;
      $text = t(theme_get_setting($pre_prefix . $node_content_type));
      $fragment = NULL;
      break;
    case 'comment_add' :
      $node_content_type = (theme_get_setting('comment_content_type') == 1) ? $vars['node']->type : 'default';
      $pre_prefix  =  ($vars['teaser']) ? 'comment_add_' : 'comment_node_';
      $url = 'comment/reply/'. $vars['node']->nid;
      $text = t(theme_get_setting($pre_prefix . $node_content_type));
      $fragment = 'comment-form';
      break;
    case 'comment_new_comments' :
      $node_content_type = (theme_get_setting('comment_content_type') == 1) ? $vars['node']->type : 'default';
      $pre_prefix  =  'comment_new_';
      $url = "node/". $vars['node']->nid;
      $text = format_plural(comment_num_new($vars['node']->nid), t(theme_get_setting($pre_prefix .'singular_'. $node_content_type)), t(theme_get_setting($pre_prefix .'plural_'. $node_content_type)));
      $fragment = 'new';
      break;
    case 'comment_comments' :
      $node_content_type = (theme_get_setting('comment_content_type') == 1) ? $vars['node']->type : 'default';
      $pre_prefix  =  'comment_';
      $url = "node/". $vars['node']->nid;
      $text = format_plural(comment_num_all($vars['node']->nid), t(theme_get_setting($pre_prefix .'singular_'. $node_content_type)), t(theme_get_setting($pre_prefix .'plural_'. $node_content_type)));
      $fragment = 'comments';
      break;
  }
  $title = cms_base_rebuild_links(
  theme_get_setting($pre_prefix .'prefix_'. $node_content_type),
  theme_get_setting($pre_prefix .'suffix_'. $node_content_type), 
  $text, 
  $url,
  array('attributes'    => array('title' => t(theme_get_setting($pre_prefix .'title_'. $node_content_type))), 
      'query'           => NULL, 
      'fragment'        => $fragment, 
      'absolute'        => FALSE, 
      'html'            => TRUE,
  ));
  $link = array('title' => $title,
    'attributes'        => array('class' => str_replace('_', '-', $pre_prefix) .'item'),  
    'html'              => TRUE,
    );
  return $link;
}



/**
 * Creates a link with prefix and suffix text
 *
 * @param $prefix
 *   The text to prefix the link.
 * @param $suffix
 *   The text to suffix the link.
 * @param $text
 *   The text to be enclosed with the anchor tag.
 * @param $path
 *   The Drupal path being linked to, such as "admin/content/node". Can be an external
 *   or internal URL.
 *     - If you provide the full URL, it will be considered an
 *   external URL.
 *     - If you provide only the path (e.g. "admin/content/node"), it is considered an
 *   internal link. In this case, it must be a system URL as the url() function
 *   will generate the alias.
 * @param $options
 *   An associative array that contains the following other arrays and values
 *     @param $attributes
 *       An associative array of HTML attributes to apply to the anchor tag.
 *     @param $query
 *       A query string to append to the link.
 *     @param $fragment
 *       A fragment identifier (named anchor) to append to the link.
 *     @param $absolute
 *       Whether to force the output to be an absolute link (beginning with http:).
 *       Useful for links that will be displayed outside the site, such as in an RSS
 *       feed.
 *     @param $html
 *       Whether the title is HTML or not (plain text)
 * @return
 *   an HTML string containing a link to the given path.
 */
function cms_base_rebuild_links($prefix, $suffix, $text, $path, $options) {
  return t($prefix . (($text) ? l($text, $path, $options) : '') . $suffix);
}


/**
 * Converts a string to a suitable html ID attribute.
 *
 * - Ensure an ID starts with an alpha character by optionally adding an 'id'.
 * - Replaces any character except alphanumeric characters with dashes.
 * - Converts entire string to lowercase.
 *
 * @param $string
 *   The string
 * @return
 *   The converted string
 */
function cms_base_id_safe($string) {
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  $string = drupal_strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
  // If the first character is not a-z, add 'id' in front.
  if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
    $string = 'id'. $string;
  }
  return $string;
}