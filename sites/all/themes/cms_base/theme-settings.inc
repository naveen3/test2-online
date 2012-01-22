<?php
// $Id$

/**
 * @file
 * theme-settings.inc
 * Contains functions to be used by theme-settings.php
 * @param $theme 
 *   Name of the theme
 * @return  
 *   An array of default values.
 */

function cms_base_default_settings($theme) {
  $themes = list_themes();

  // Gets the default values from the .info file.
  $defaults = !empty($themes[$theme]->info['settings']) ? $themes[$theme]->info['settings'] : array();
      
  // Gets the node types
  $node_types = node_get_types('names');

  // Sets the default values for content-type-specific settings
  foreach ($node_types as $type => $name) {
    $defaults["comment_singular_{$type}"]         = $defaults['comment_singular_default'];
    $defaults["comment_plural_{$type}"]           = $defaults['comment_plural_default'];
    $defaults["comment_title_{$type}"]            = $defaults['comment_title_default'];
    $defaults["comment_prefix_{$type}"]           = $defaults['comment_prefix_default'];
    $defaults["comment_suffix_{$type}"]           = $defaults['comment_suffix_default'];
    $defaults["comment_new_singular_{$type}"]     = $defaults['comment_new_singular_default'];
    $defaults["comment_new_plural_{$type}"]       = $defaults['comment_new_plural_default'];
    $defaults["comment_new_title_{$type}"]        = $defaults['comment_new_title_default'];
    $defaults["comment_new_prefix_{$type}"]       = $defaults['comment_new_prefix_default'];
    $defaults["comment_new_suffix_{$type}"]       = $defaults['comment_new_suffix_default'];
    $defaults["comment_add_{$type}"]              = $defaults['comment_add_default'];
    $defaults["comment_add_title_{$type}"]        = $defaults['comment_add_title_default'];
    $defaults["comment_add_prefix_{$type}"]       = $defaults['comment_add_prefix_default'];
    $defaults["comment_add_suffix_{$type}"]       = $defaults['comment_add_suffix_default'];
    $defaults["comment_node_{$type}"]             = $defaults['comment_node_default'];
    $defaults["comment_node_title_{$type}"]       = $defaults['comment_node_title_default'];
    $defaults["comment_node_prefix_{$type}"]      = $defaults['comment_node_prefix_default'];
    $defaults["comment_node_suffix_{$type}"]      = $defaults['comment_node_suffix_default'];
    $defaults["taxonomy_display_{$type}"]         = $defaults['taxonomy_display_default'];
    $defaults["taxonomy_format_{$type}"]          = $defaults['taxonomy_format_default'];
    $defaults["submitted_by_author_{$type}"]      = $defaults['submitted_by_author_default'];
    $defaults["submitted_by_date_{$type}"]        = $defaults['submitted_by_date_default'];
    $defaults["readmore_{$type}"]                 = $defaults['readmore_default'];
    $defaults["readmore_title_{$type}"]           = $defaults['readmore_title_default'];
    $defaults["readmore_prefix_{$type}"]          = $defaults['readmore_prefix_default'];
    $defaults["readmore_suffix_{$type}"]          = $defaults['readmore_suffix_default'];
  }

  $settings = theme_get_settings($theme);
  // removing the toggle_node_info_ variables.
  if (module_exists('node')) {
    foreach (node_get_types() as $type => $name) {
        unset($settings['toggle_node_info_'. $type]);
    }

    // Save default theme settings.
    variable_set(
      str_replace('/', '_', 'theme_'. $theme .'_settings'),
      array_merge($defaults, $settings)
    );
    // If the active theme has been loaded, force refresh of Drupal internals.
    if (!empty($GLOBALS['theme_key'])) {
      theme_get_setting('', TRUE);
    }
  }
  return $defaults;
}