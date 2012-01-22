<?php
// $Id$

/**		
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 */



/**
 * Implementation of HOOK_theme().
 */
function cmssimplicity_theme(&$existing, $type, $theme, $path) {
  $hooks = cms_base_theme($existing, $type, $theme, $path);
  
  return $hooks;
}


/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cmssimplicity_preprocess_page(&$vars) {
  //Adding stylesheet for color 
  $theme_color_style = theme_get_setting('theme_color_style');
  $theme_background = theme_get_setting('theme_background');
  $css_color_style_path = path_to_theme() .'/css/colors/'. $theme_color_style .'/'. $theme_color_style .'.css';
  if (!file_exists($css_color_style_path)) {
    $css_color_style_path = drupal_get_path('theme', 'cmssimplicity') .'/css/colors/'. $theme_color_style .'/'. $theme_color_style .'.css';
  }
  $background_color_style_path = path_to_theme() .'/css/background/'. $theme_background .'/'. $theme_background .'.css';
  if (!file_exists($background_color_style_path)) {
    $background_color_style_path = drupal_get_path('theme', 'cmssimplicity') .'/css/background/'. $theme_background .'/'. $theme_background .'.css';
  }
  $themes = array();
  foreach ($vars['css']['all']['theme'] as $key => $value) {
    $themes[$key] = $value;
    if ($key ==  drupal_get_path('theme', 'cmssimplicity') .'/css/cmssimplicity.css') {
      $themes[$css_color_style_path] = 1;
      $themes[$background_color_style_path] = 1;
    }
  }
  $vars['css']['all']['theme'] = $themes;
  $vars['styles'] = drupal_get_css($vars['css']);
  if (!module_exists('conditional_styles')) {
    $vars['styles'] .= $vars['conditional_styles'] = variable_get('conditional_styles_'. $GLOBALS['theme'], '');
  }


  $classes = split(' ', $vars['body_classes']);
  // Add class to body depends on selected primary menu from theme settings. 
  $vars['body_classes_array'] = $classes;
  $classes[] = 'color-'. $theme_color_style;
  $classes[] = 'bg-'. $theme_background;
  $vars['body_classes'] = implode(' ', $classes); // Concatenate with spaces.
  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }

}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cmssimplicity_preprocess_node(&$vars) {
  if ($vars['picture']) {
    $classes = explode(' ',$vars['classes']) ;
	$classes[] = 'user-picture';
    $vars['classes'] = implode(' ',$classes);
  }

  $node = $vars['node'];
  
  // override the subbmitted text according to requirment
  $author  = "posted by ";
  $author .= theme('username', $node);
  $posted_date = date('F d, Y ', $node->created); 
  $submitted = '';
  $submitted_by_content_type = (theme_get_setting('submitted_by_content_type') == 1) ? $node->type : 'default';
  $author_setting = (theme_get_setting('submitted_by_author_'. $submitted_by_content_type) == 1);
   $date_setting = (theme_get_setting('submitted_by_date_'. $submitted_by_content_type) == 1);
  
  
  if ($author_setting) {
    $submitted = $author . ' ';
  }
  if ($date_setting) {
    $submitted .= $posted_date;
  }
  $vars['submitted'] = $submitted;
  
    //Formating taxonomy term list according to theme's requirement
  $taxonomy_content_type = (theme_get_setting('taxonomy_enable_content_type') == 1) ? $vars['node']->type : 'default';
  $taxonomy_display = theme_get_setting('taxonomy_display_'. $taxonomy_content_type);
  $taxonomy_format = theme_get_setting('taxonomy_format_'. $taxonomy_content_type);
  if ($taxonomy_display == 'all' || ($taxonomy_display == 'only' && $vars['page'])) {
    $vocabularies = taxonomy_get_vocabularies($vars['node']->type);
    $vars['terms']  = '';
    $term_delimiter = '&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;';
    foreach ($vocabularies as $vocabulary) {
       if (theme_get_setting('taxonomy_vocab_hide_'. $taxonomy_content_type .'_'. $vocabulary->vid) != 1) {
        $terms = taxonomy_node_get_terms_by_vocabulary($vars['node'], $vocabulary->vid);
        if ($terms) {
          $term_items = '';
          foreach ($terms as $term) {                        // Build vocabulary term items
            $term_link = l($term->name, taxonomy_term_path($term), array('attributes' => array('rel' => 'tag', 'title' => strip_tags($term->description))));
            $term_items .=  $term_delimiter .$term_link ;
			}
          if ($taxonomy_format == 'vocab') {                 // Add vocabulary labels if separate
            $vars['terms'] .= '<span class="vocab-name">'. $vocabulary->name .':</span>';
            $vars['terms'] .= $term_items;
          }
          else {
            $vars['terms'] .= $term_items;
          }
        }
      }
    }
    if ($vars['terms'] != '') {
        $vars['terms'] =  $vars['terms'] ;
    }
  }


}


/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cmssimplicity_preprocess_comment(&$vars) {
  //print_r($vars);die;
  $comment = $vars['comment'];
  // override the subbmitted text according to requirment
  $author  = "";
  $author .= theme('username', $comment);
  $posted_date = '<div class="date-calendar"><span class="month-year">'. strtoupper(date('M Y ', $node->created)) .'</span><span class="date">'. date('d ', $node->created) .'</span>
</div>'; 
  $submitted = '';
  $submitted_by_content_type = (theme_get_setting('submitted_by_content_type') == 1) ? $node->type : 'default';
  $author_setting = (theme_get_setting('submitted_by_author_'. $submitted_by_content_type) == 1);
  if ($author_setting) {
    $submitted = $author;
  }
  $date_setting = (theme_get_setting('submitted_by_date_'. $submitted_by_content_type) == 1);
  if ($date_setting) {
	$submitted.=' | ' . strtoupper(date('F j, Y @ h:i A', $comment->timestamp));
  }
  $vars['submitted'] = $submitted;

  $classes = split(' ', $vars['classes']);
  $classes[]  = ($vars['picture']) ? 'user-picture':'';
  $vars['classes'] = implode(' ', $classes); // Concatenate with spaces.
}


/**
 * Helper function that builds the nested lists of a nice menu.
 *
 * @param $menu
 *   Menu array from which to build the nested lists.
 */
function cmssimplicity_nice_menu_build($menu) {
  $output = '';
  $flag = 1;
  $item_count = count($menu);
  foreach ($menu as $menu_item) {
    $mlid = $menu_item['link']['mlid'];
    // Check to see if it is a visible menu item.
    if ($menu_item['link']['hidden'] == 0) {
      // Build class name based on menu path
      // e.g. to give each menu item individual style.
      // Strip funny symbols.
      $clean_path = str_replace(array('http://', '<', '>', '&', '=', '?', ':'), '', $menu_item['link']['href']);
      // Convert slashes to dashes.
      $clean_path = str_replace('/', '-', $clean_path);
      $path_class = 'menu-path-'. $clean_path;
      // Adding first and last class 
      if ($flag == 1 ) {
        $path_class .= ' first';
      }
      if ($flag == $item_count ) {
        $path_class .= ' last';
      }
      $flag++;
      // End - Adding first and last class 
      // If it has children build a nice little tree under it.
      if ((!empty($menu_item['link']['has_children'])) && (!empty($menu_item['below']))) {
        // Keep passing children into the function 'til we get them all.
        $children = theme('nice_menu_build', $menu_item['below']);
        // Set the class to parent only of children are displayed.
        $parent_class = $children ? 'menuparent ' : '';
        $output .= '<li id="menu-'. $mlid .'" class="'. $parent_class . $path_class .'">'. theme('menu_item_link', $menu_item['link']);
        // Build the child UL only if children are displayed for the user.
        if ($children) {
          $output .= '<ul>';
          $output .= $children;
          $output .= "</ul>\n";
        }
        $output .= "</li>\n";
      }
      else {
        $output .= '<li id="menu-'. $mlid .'" class="'. $path_class .'">'. theme('menu_item_link', $menu_item['link']);
              $output .= '</li>'."\n";

      }
    }
  }
  return $output;
}

/**
 * Theme a "you can't post comments" notice.
 *
 * @param $node
 *   The comment node.
 * @ingroup themeable
 */
function cmssimplicity_comment_post_forbidden($node) {
  global $user;
  //die();
  static $authenticated_post_comments;

  if (!$user->uid) {
    if (!isset($authenticated_post_comments)) {
      // We only output any link if we are certain, that users get permission
      // to post comments by logging in. We also locally cache this information.
      $authenticated_post_comments = array_key_exists(DRUPAL_AUTHENTICATED_RID, user_roles(TRUE, 'post comments') + user_roles(TRUE, 'post comments without approval'));
    }

    if ($authenticated_post_comments) {
      // We cannot use drupal_get_destination() because these links
      // sometimes appear on /node and taxonomy listing pages.
      if (variable_get('comment_form_location_'. $node->type, COMMENT_FORM_SEPARATE_PAGE) == COMMENT_FORM_SEPARATE_PAGE) {
        $destination = 'destination='. rawurlencode("comment/reply/$node->nid#comment-form");
      }
      else {
        $destination = 'destination='. rawurlencode("node/$node->nid#comment-form");
      }

      if (variable_get('user_register', 1)) {
        // Users can register themselves.
        return t('<a href="@login">Login</a> <span class="regular_text"> or </span><a href="@register">register</a> <span class="regular_text">to post comments</span>', array('@login' => url('user/login', array('query' => $destination)), '@register' => url('user/register', array('query' => $destination))));
      }
      else {
        // Only admins can add new users, no public registration.
        return t('<a href="@login">Login</a> <span class="regular_text">to post comments</span>', array('@login' => url('user/login', array('query' => $destination))));
      }
    }
  }
}


/**
 * Process variables for forums.tpl.php
 *
 * The $variables array contains the following arguments:
 * - $forums
 * - $topics
 * - $parents
 * - $tid
 * - $sortby
 * - $forum_per_page
 *
 * @see forums.tpl.php
 */
function cmssimplicity_preprocess_forums(&$variables) {
  global $user;
  if (isset($variables['links']['login'])) {
    $variables['links']['login']['title'] = str_replace('to post new content in the forum.','<span class="regular_text">to post new content in the forum.</span>',$variables['links']['login']['title']);
  }
}

drupal_add_js("$(document).ready(function() {  
  $('#edit-search-block-form-1').val('". t('Search') ."');
  $('#edit-search-block-form-1').focus(function() { if ($(this).val() == '". t('Search') ."') $(this).val(''); });
  $('#edit-search-block-form-1').blur(function() { if ($(this).val() == '') $(this).val('". t('Search') ."'); });});
", 'inline', 'footer');