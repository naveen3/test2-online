<?php
// $Id$

/**
 * @file
 * Allows themes to add conditional stylesheets.
 */

/**
 * Returns paths for the theme and its base themes.
 *
 * @param $theme
 *   The name of the theme.
 * @return
 *   An array of all the theme paths.
 */
function conditional_styles_paths_to_basetheme($theme) {
  static $theme_paths;
  if (empty($theme_paths[$theme])) {
    $theme_paths[$theme] = array();
    $themes = list_themes();
    // Grabs the paths from the base theme.
    if (!empty($themes[$theme]->base_theme)) {
      $theme_paths[$theme] = conditional_styles_paths_to_basetheme($themes[$theme]->base_theme);
    }
    $theme_paths[$theme][$theme] = dirname($themes[$theme]->filename);
  }
  return $theme_paths[$theme];
}

/**
 * When the theme registry is rebuilt, we also build the conditional stylesheets.
 */
function _conditional_styles_theme($existing, $type, $theme, $path) {

  // Processes the conditional stylesheets for every active theme.
  $themes = list_themes();
  foreach (array_keys($themes) AS $theme) {
    // We only need to process active themes.
    if ($themes[$theme]->status) {
      $paths = conditional_styles_paths_to_basetheme($theme);

      // Grabs all the conditional stylesheets.
      $stylesheets = array();
      // Starts with the base theme and travels up the chain to the active theme.
      foreach ($paths AS $theme_name => $path) {
        // Looks at the conditional-stylesheets defined in the theme's .info file.
        if (!empty($themes[$theme_name]->info['conditional-stylesheets'])) {
          foreach ($themes[$theme_name]->info['conditional-stylesheets'] AS $condition => $css) {
            // Allows the theme to override its base themes' styles.
            foreach ($css AS $media => $files) {
              foreach ($files AS $file) {
                $stylesheets[$condition][$media][$file] = $path;
              }
            }
          }
        }
      }
      // Renders the stylesheets to link elements.
      $conditional_styles = '';
      if (!empty($stylesheets)) {
        $query_string = '?'. drupal_substr(variable_get('css_js_query_string', '0'), 0, 1);
        $base_path = base_path();
        foreach ($stylesheets AS $condition => $css) {
          // Each condition requires its own set of links.
          $output = '';
          foreach ($css AS $media => $files) {
            foreach ($files AS $file => $path) {
              // Doesn't allow non-existent stylesheets to clutter the logs with 404.
             // if (file_exists("./$path/$file")) {
                $output .= "<link type=\"text/css\" rel=\"stylesheet\" media=\"$media\" href=\"$base_path$path/$file$query_string\" />\n";
            //  }
            }
          }
          if ($output) {
            $conditional_styles .= "<!--[$condition]>\n$output<![endif]-->\n";
          }
        }
      }
      // Saves the stylesheets for later retrieval.
      if ($conditional_styles) {
        variable_set('conditional_styles_'. $theme, $conditional_styles);
      }
      else {
        variable_del('conditional_styles_'. $theme);
      }
    }
  }

  // Returns nothing.
  return array();
}
