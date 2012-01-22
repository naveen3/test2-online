<?php
// $Id$
    
/** 
 * @file
 * Contains theme override functions and preprocess functions for the CMS Base theme.
 *
 * IMPORTANT WARNING: DO NOT MODIFY THIS FILE.
 *
 */
include_once './'. drupal_get_path('theme', 'cms_base') .'/template.inc';

// Auto-rebuild the theme registry during theme development if it is enabled from theme settings.
_cms_base_initialize();


/**
 * Implements HOOK_theme().
 */
function cms_base_theme(&$existing, $type, $theme, $path) {
  if (!db_is_active()) {
    return array();
  }
  return _cms_base_theme($existing, $type, $theme, $path);
}



/**
 * Override or insert PHPTemplate variables into the templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cms_base_preprocess_page(&$vars) {
  global $base_root;
  // Add conditional stylesheets.
  if (!module_exists('conditional_styles')) {
    $vars['styles'] .= $vars['conditional_styles'] = variable_get('conditional_styles_'. $GLOBALS['theme'], '');
  }
  
  if ($vars['logo'] != '') {
	  //Extract logo size, used for maintain header vertically aligned 
    $logo_path_name = $_SERVER['DOCUMENT_ROOT'] . $vars['logo'];
    if (file_exists($logo_path_name)) {
      if ($logo_size = getimagesize($logo_path_name )) {
        $vars['logo_size'] = $logo_size; 
      }
    }
	}
  // Remove default classes depending on sidebars availablity  
  $vars['body_classes'] = str_replace('sidebar-left', '', $vars['body_classes']);
  $vars['body_classes'] = str_replace('sidebar-right', '', $vars['body_classes']);
  $vars['body_classes'] = str_replace('one-sidebar', '', $vars['body_classes']);
  $vars['body_classes'] = str_replace('two-sidebars', '', $vars['body_classes']);
  $vars['body_classes'] = str_replace('no-sidebars', '', $vars['body_classes']);

  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  $classes = split(' ', $vars['body_classes']);
  // Remove the mostly useless page-ARG0 class.
  if ($index = array_search(preg_replace('![^abcdefghijklmnopqrstuvwxyz0-9-_]+!s', '', 'page-'. drupal_strtolower(arg(0))),  $classes))    {
    unset($classes[$index]);
  }
  if (!$vars['is_front']) {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    $classes[] = cms_base_id_safe('page-'. $path);
    // Add unique class for each website section.
    list($section, ) = explode('/', $path, 2);
    if (arg(0) == 'node') {
      if (arg(1) == 'add') {
        $section = 'node-add';
      }
      elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
        $section = 'node-'. arg(2);
      }
    }
    $classes[] = cms_base_id_safe('section-'. $section);
  }
  if ($vars['navbar']) {
    $classes[] = 'navigation';
  }
 
  if ($vars['left']) {    // add class depending on availability of ssidebars.
    if ($vars['right']) {
      $classes[] = ($vars['right_sidebar2']) ? 'sidebar-left-right-right2' : 'sidebar-left-right';
    }
    else {
      $classes[] = ($vars['right_sidebar2']) ? 'sidebar-left-right2' : 'sidebar-left';
    } 
  }
  else {
    if ($vars['right']) {
      $classes[] = ($vars['right_sidebar2']) ? 'sidebar-right-right2' : 'sidebar-right';
    }
    else {
      $classes[] = ($vars['right_sidebar2']) ? 'sidebar-right2' : 'no-sidebars';
    } 
  }

  // Calculate and set variable for width of sidebar left,right, right2 and the body area depending upon theme settings and availability of region on current page
  $vars['sidebar_left_width'] = number_format(theme_get_setting('sidebar_left_width'));
  $vars['width_sidebar_right'] = number_format(theme_get_setting('width_sidebar_right'));
  $vars['width_sidebar_right2'] = number_format(theme_get_setting('width_sidebar_right2'));
  $vars['width_content_body'] = 940;
  if ($vars['left'] && $vars['right'] && $vars['right_sidebar2']) {
    $vars['width_content_body'] = 880 - $vars['sidebar_left_width'] - $vars['width_sidebar_right'] - $vars['width_sidebar_right2'];
  }
  elseif (!$vars['left'] && !$vars['right'] && !$vars['right_sidebar2']) {
    $vars['width_content_body'] = 940;
  }
  else {
    if ($vars['left']) {
      $vars['width_content_body'] -=$vars['sidebar_left_width']+20;
    }  
    if ($vars['right']) {
      $vars['width_content_body'] -=$vars['width_sidebar_right']+20;
    }  
    if ($vars['right_sidebar2']) {
      $vars['width_content_body'] -=$vars['width_sidebar_right2']+20;
    }  
  }



  // Set variable for font family depends on theme settings
  $vars['body_text_font'] = (theme_get_setting('body_text_font') == 'Custom') ? theme_get_setting('body_text_font_custom') : theme_get_setting('body_text_font');
  
  $vars['heading_text_font'] = (theme_get_setting('heading_text_font') == 'Custom') ? theme_get_setting('heading_text_font_custom') : theme_get_setting('heading_text_font');

  $vars['body_classes_array'] = $classes;
  $vars['body_classes'] = implode(' ', $classes); // Concatenate with spaces.
  // setting up variable to show/hide tooltip according to theme settings.
  $myvars =array('CMSBASE' => array('TOOLTIP' => theme_get_setting('show_tooltip')));
  drupal_add_js($myvars,'setting'); 

}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cms_base_preprocess_node(&$vars) {
  // overriding default teaser with Teaser field's value if its not empty
  if ($vars['teaser'] && !empty($vars['field_teaser'][0]['view'])) {
    $teaser_text = trim(str_replace('<p>&nbsp;</p>','',$vars['field_teaser'][0]['view']));
    if (  !empty($teaser_text)) {
	  $vars['content'] = $vars['field_teaser'][0]['view'];
	}
  }
  // Special classes for nodes.Allows advanced theming based on context.
  $classes = array();
  $classes[] = ($vars['sticky']) ? 'sticky' : '';                   // Node is sticky
  $classes[] = (!$vars['status']) ? 'node-unpublished' : '';  // Node is unpublished
  $classes[] = $vars['zebra'];
  $classes[] = ($vars['uid'] && $vars['uid'] == $GLOBALS['user']->uid) ? 'node-mine' : '';   // Node is odd or even
  $classes[] = !empty($vars['teaser']) ? 'teaser' : 'full-node';    // Node is teaser or full-node
  $classes[] = 'node-type-'. $vars['type'];                   // Node is type-x, e.g., node-type-page
  $classes      = array_filter($classes);                           // Remove empty elements
  $vars['classes'] = implode(' ', $classes);                   // Implode class list with spaces

  // Node Theme Settings

  // Date & author
  if (!module_exists('submitted_by')) {
    $vars['submitted'] = _cms_node_submitted_by_text($vars['node']);
  }

  // Taxonomy
  if (module_exists('taxonomy')) {
    $vars['terms'] = _cms_base_node_term_list($vars);
  }
  // Node Links
  if (isset($vars['node']->links['node_read_more'])) {
      $vars['node']->links['node_read_more'] = _cms_base_node_links($vars, 'node_read_more');
  }
  if (isset($vars['node']->links['comment_add'])) {
      $vars['node']->links['comment_add'] = _cms_base_node_links($vars, 'comment_add');

  }
  if (isset($vars['node']->links['comment_new_comments'])) {
      $vars['node']->links['comment_new_comments'] = _cms_base_node_links($vars, 'comment_new_comments');
  }
  if (isset($vars['node']->links['comment_comments'])) {
      $vars['node']->links['comment_comments'] = _cms_base_node_links($vars, 'comment_comments');
  }
  $vars['links'] = theme('links', $vars['node']->links, array('class' => 'links inline'));
}


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return 
 *   A string containing the breadcrumb output.
 */
function cms_base_breadcrumb($breadcrumb) {
  $show_breadcrumb = theme_get_setting('breadcrumb');
  switch ($show_breadcrumb) {
    case 'no' :
      $output =  '';
      break;
    case 'admin' :
      if (arg(0) != 'admin') {
        $output =  '';
        break;
      }
    case 'yes' :
      // Optionally get rid of the homepage link.
      $breadcrumb_home_link = theme_get_setting('breadcrumb_home_link');
      if (!$breadcrumb_home_link) {
        array_shift($breadcrumb);
      }
      if (!empty($breadcrumb)) {
        $breadcrumb_separator = ' '. theme_get_setting('breadcrumb_separator') .' ';
        $trailing_separator = $title = '';
        if (theme_get_setting('breadcrumb_title')) {
          $trailing_separator = $breadcrumb_separator;
          $title = drupal_get_title();
        } 
        elseif (theme_get_setting('breadcrumb_trailing_separator')) {
          $trailing_separator = $breadcrumb_separator;
        }
        $output =  '<div class="breadcrumb">'. implode($breadcrumb_separator, $breadcrumb) ."$trailing_separator$title</div>";
      }
  }
  return $output;
}


/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cms_base_preprocess_block(&$vars) {
  $block = $vars['block'];
  // Special classes for blocks.Allows advanced theming based on context.
  $classes = array();
  $classes[] = 'block-'. $block->module;
  $classes[] = 'region-'. $vars['block_zebra'];
  $classes[] = $vars['zebra'];
  $classes[] = 'region-count-'. $vars['block_id'];
  $classes[] = 'count-'. $vars['id'];
  $vars['edit_links_array'] = array();
  $vars['edit_links'] = '';
  if (theme_get_setting('block_editing_link') && user_access('administer blocks')) {
    $classes[] = 'with-block-editing';
    $vars['block_edit_links_array'] = _cms_base_block_editing_links($vars['block']);
    foreach ($vars['block_edit_links_array'] as $edit_link) {
      $links[] = l('<span>'. $edit_link['title'] .'</span>', $edit_link['url'], 
        array( 'attributes' => $edit_link['attributes'],
          'query' => $edit_link['query'],
          'fragment' => $edit_link['fragment'],
          'html'  => TRUE,
        )
      );   
    }
    $vars['block_edit_links'] = '<div class="block-edit">'. implode(' ', $links) .'</div>';
  }


  // Grid class on basis of block count like 'grid_4 if there are for blocks in region (listed in array)
  $dynamic_regions = array( 'content_top1', 'content_top4', 'content_bottom2', 'content_bottom3', 'footer', 'footer2');
  if (in_array($vars['block']->region, $dynamic_regions)) {
    $block_total_count = count(block_list($vars['block']->region));
    $block_total_count = ($block_total_count >= 4) ? 4 : $block_total_count ;   
    $block_count = 12/$block_total_count;
    $classes[] = ' grid_'. $block_count;
  } 
  // Render block classes.
  $vars['classes'] = implode(' ', $classes);
}


/**
 * Override username theming to display/hide 'not verified' text
 * @param $object
 *   The user object to format.
 * @return
 *   A string containing an HTML link to the user's page if the passed object suggests that this is a site user. Otherwise, only the username is returned.
 */
function cms_base_username($object) {
  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) .'...';
    }
    else {
      $name = $object->name;
    }
    if (user_access('access user profiles')) {
      $output = l($name, 'user/'. $object->uid, array('attributes' => array('title' => t('View user profile.'))));
    }
    else {
      $output = check_plain($name);
    }
  }
  else if ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the TRUE author of the content.
    if (!empty($object->homepage)) {
      $output = l($object->name, $object->homepage, array('attributes' => array('rel' => 'nofollow')));
    }
    else {
      $output = check_plain($object->name);
    }
    // Display/Hide 'not verified' text
    if (theme_get_setting('user_notverified_display') == 1) {
      $output .= t(' (not verified)');
    }
  }
  else {
    $output = variable_get('anonymous', t('Anonymous'));
  }
  return $output;
}


/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function cms_base_preprocess_comment(&$vars) {

  // If comment subjects are disabled, don't display them.
  if (variable_get('comment_subject_field_'. $vars['node']->type, 1) == 0) {
    $vars['title'] = '';
  }

  // Special classes for comments.Allows advanced theming based on context.
  $classes = array();
  $classes[] = $vars['zebra'];
  $classes[] = $vars['status'];  
  $classes[] = ($vars['comment']->new) ? 'comment-new' : '';  
  $classes[] = ($vars['id'] == 1) ? 'first' : ''; 
  $classes[] = ($vars['id'] == $vars['node']->comment_count) ? 'last' : '';
  $classes[] = ($vars['comment']->uid == 0) ? 'comment-by-anon' : '';
  $classes[] = ($user->uid && $vars['comment']->uid == $user->uid) ? 'comment-mine' : '';
  $classes[] = ($user->uid && $vars['comment']->uid == $vars['node']->uid) ? 'comment-by-author' : '';
  $classes = array_filter($classes); // Remove empty elements
  $vars['classes'] = implode(' ', $classes);

}


 /**
 * Modify search results based on theme settings
 *
 * @param $variables
 *     Array contains the following arguments:
 *     $results
 *     $type
 */
function cms_base_preprocess_search_result(&$variables) {
  $result = $variables['result'];
  $variables['url'] = check_url($result['link']);
  $variables['title'] = check_plain($result['title']);

  $info = array();
  if (!empty($result['type']) && theme_get_setting('search_node_type')) {
    $info['type'] = check_plain($result['type']);
  }
  if (!empty($result['date']) && theme_get_setting('search_posted_date')) {
    $info['date'] = 'Posted on '. format_date($result['date'], 'small');
  }
  if (!empty($result['user']) && theme_get_setting('search_author_name')) {
    $info['date'] .= ' by '. $result['user'];
  }  
  if (isset($result['extra']) && is_array($result['extra'])) {
    if (!empty($result['extra'][0]) && theme_get_setting('search_node_comments')) {
      $info['comment'] = $result['extra'][0];
    }
    if (!empty($result['extra'][1]) && theme_get_setting('search_attachment_count')) {
      $info['upload'] = $result['extra'][1];
    }
  }
  // Check for existence. User search does not include snippets.
  $variables['snippet'] = '';
  if (isset($result['snippet']) && theme_get_setting('search_text_snippet')) {
    $variables['snippet'] = $result['snippet'];
  }
  
  // Provide separated and grouped meta information.
  $variables['info_split'] = $info;
  $variables['info'] = t(implode(' - ', $info));

  // Provide alternate search result template.
  $variables['template_files'][] = 'search-result-'. $variables['type'];
}