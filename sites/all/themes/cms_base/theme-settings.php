<?php 
// $Id$
/**
 * @file
 * Adds some theme settings features to theme.
 */

// Includes the file containing helper functions.
include_once './'. drupal_get_path('theme', 'cms_base') .'/theme-settings.inc';


/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings 
 *   An array of saved settings for this theme.
 * @param $subtheme_defaults
 *   Allows a subtheme to override the default values.
 * @return
 *   An array of form. 
 */
function cms_base_settings($saved_settings, $subtheme_defaults = array()) {

  $defaults = cms_base_default_settings('cms_base');

  // Allows a subtheme to override the default values.
  $defaults = array_merge($defaults, $subtheme_defaults);

  // Merges the saved variables and their default values.
  $settings = array_merge($defaults, $saved_settings);

  
  // Creates the form for theme settings page.
  $form = array();
   // Extra variable settings for this theme

  // layout settings
  $form['layout'] = array(
    '#type'         => 'fieldset',
    '#title'         => t('Layout settings'),
    '#collapsible'  => TRUE,
    '#collapsed'     => TRUE,
  );

  $form['layout']['sidebar_left_width'] = array(   //defines the custom width for leftsidebar
    '#type'              => 'textfield',
    '#title'            => t('Left sidebar width'),
    '#size'             => 10,
    '#default_value'     => $settings['sidebar_left_width'],
    '#field_suffix'     => t('px'),
  );

  $form['layout']['width_sidebar_right'] = array(   //defines the custom width for rightsidebar
    '#type'              => 'textfield',
    '#title'             => t('Right sidebar width'),
    '#size'             => 10,
    '#default_value'     => $settings['width_sidebar_right'],
    '#field_suffix'     => t('px'),
  );


  $form['layout']['width_sidebar_right2'] = array(   //defines the custom width for rightsidebar2
    '#type'              => 'textfield',
    '#title'             => t('Right sidebar 2 width'),
    '#size'             => 10,
    '#default_value'     => $settings['width_sidebar_right2'],
    '#field_suffix'     => t('px'),
    '#description'       => l(t('View instructions for using the sidebar settings'), 'http://www.cmsquickstart.com/drupal-theme-guides/sidebar-settings', array( 'attributes' => array('target' => "_blank"), 'absolute' => TRUE)),
  );

  $form['layout']['show_tooltip'] = array(
      '#type'             => 'checkbox',
      '#title'             => t('Check to show tool tip when hovering over the primary links menu.'),
      '#default_value'     => $settings['show_tooltip'],
	  '#weight'			  =>  11,  
  );


  //font settings
  $form['font_settings'] = array(
    '#type'         => 'fieldset',
    '#title'         => t('Font settings'),
    '#collapsible'  => TRUE,
    '#collapsed'     => TRUE,
    '#description'     => t(''),
  );

  $form['font_settings']['use_css_for_fonts'] = array(
      '#type'             => 'checkbox',
      '#title'             => t('Use CSS for fonts'),
      '#default_value'     => $settings['use_css_for_fonts'],
  );

  $form['font_settings']['body_text'] = array(
    '#type'         => 'fieldset',
    '#title'         => t('Body text font'),
    '#collapsible'     => TRUE,
    '#collapsed'     => TRUE,
    '#description'     => t('Font used for the body text of content types, comments, and blocks.'),
  );

  $form['font_settings']['body_text']['body_text_font'] = array(
    '#type'             => 'select',
    '#title'             => t('Font family'),
    '#default_value'     => $settings['body_text_font'],
    '#options'             => array(
      "Georgia, 'Times New Roman', Times, serif"     => t("Georgia, 'Times New Roman', Times, serif"),
      "'Times New Roman', Times, Georgia, serif"     => t("'Times New Roman', Times, Georgia, serif"),
      "Verdana, Arial, Helvetica, sans-serif"         => t("Verdana, Arial, Helvetica, sans-serif"),
      "Helvetica, Arial, Verdana, sans-serif"         => t("Helvetica, Arial, Verdana, sans-serif'"),
      "Tahoma, Verdana, Arial, sans-serif"             => t("Tahoma, Verdana, Arial, sans-serif"),
      'Custom'                                         => t('Custom (specify below)'),
    ),
     '#description'     => t("Default font family -  Georgia, 'Times New Roman', Times, serif"),
  );

  $form['font_settings']['body_text']['body_text_font_custom'] = array(
    '#type'             => 'textfield',
    '#title'             => t('Custom font-family setting'),
    '#default_value'     => $settings['body_text_font_custom'],
    '#size'             => 40,
    '#maxlength'         => 200,
    '#description'         => t("Enter fonts in order of priority separated by commas. If the user's computer does not have the font it will use the next font listed in order of priority. For example: Verdana, Arial, 'Times New Roman' - in this example if the user does not have Verdana then their computer will look for Arial and then for Times Roman.<br /><b>Note:</b> Put ' before and after any fonts that have a space such as 'Times New Roman'."),
  );
  $form['font_settings']['headings_text_font'] = array(
    '#type'             => 'fieldset',
    '#title'             => t('Headings text font'),
    '#collapsible'         => TRUE,
    '#collapsed'         => TRUE,
    '#description'         => t('Font used for h1-h6 headings, navigation links, site name and slogan.'),
  );

  $form['font_settings']['headings_text_font']['heading_text_font'] = array(
    '#type'             => 'select',
    '#title'             => t('Font family'),
    '#default_value'     => $settings['heading_text_font'],
    '#options' => array(
     "Georgia, 'Times New Roman', Times, serif"     => t("Georgia, 'Times New Roman', Times, serif"),
     "'Times New Roman', Times, Georgia, serif"     => t("'Times New Roman', Times, Georgia, serif"),
     "Verdana, Arial, Helvetica, sans-serif"         => t("Verdana, Arial, Helvetica, sans-serif"),
     "Helvetica, Arial, Verdana, sans-serif"         => t("Helvetica, Arial, Verdana, sans-serif'"),
     "Tahoma, Verdana, Arial, sans-serif"             => t("Tahoma, Verdana, Arial, sans-serif"),
     'Custom'                                         => t('Custom (specify below)'),
    ),
     '#description'     => t("Default font family -  Georgia, 'Times New Roman', Times"),
  );

  $form['font_settings']['headings_text_font']['heading_text_font_custom'] = array(
    '#type'             => 'textfield',
    '#title'             => t('Custom font-family setting'),
    '#default_value'     => $settings['heading_text_font_custom'],
    '#size'             => 40,
    '#maxlength'         => 200,
    '#description'         => t("Enter fonts in order of priority separated by commas. If the user's computer does not have the font it will use the next font listed in order of priority. For example: Verdana, Arial, 'Times New Roman' - in this example if the user does not have Verdana then their computer will look for Arial and then for Times Roman.<br /><b>Note:</b> Put ' before and after any fonts that have a space such as 'Times New Roman'."),
  );



  // Search Settings
  if (module_exists('search')) {
    $form['search_settings'] = array(
      '#type'             => 'fieldset',
      '#title'             => t('Search results'),
      '#description'     => t('Select additional information you would like to be displayed with search results.'),
      '#collapsible'     => TRUE,
      '#collapsed'         => TRUE,
    );
    $form['search_settings']['search_author_name'] = array(
      '#type'             => 'checkbox',
      '#title'             => t('Author name'),
      '#default_value'     => $settings['search_author_name'],
    );
    $form['search_settings']['search_posted_date'] = array(
      '#type'             => 'checkbox',
      '#title'             => t('Node posted date'),
      '#default_value'     => $settings['search_posted_date'],
    );

    $form['search_settings']['search_text_snippet'] = array(
      '#type'             => 'checkbox',
      '#title'             => t('Text snippet'),
      '#default_value'     => $settings['search_text_snippet'],
    );
    $form['search_settings']['search_node_type'] = array(
      '#type'             => 'checkbox',
      '#title'             => t('Content type name'),
      '#default_value'     => $settings['search_node_type'],
    );

    $form['search_settings']['search_node_comments'] = array(
      '#type'             => 'checkbox',
      '#title'             => t('Comment count'),
      '#default_value'     => $settings['search_node_comments'],
    );
    $form['search_settings']['search_attachment_count'] = array(
      '#type'             => 'checkbox',
      '#title'             => t('Number of attachments'),
      '#default_value'     => $settings['search_attachment_count'],
    );
  }
  
  // Node Settings
  $form['node_specific_settings'] = array(
    '#type'         => 'fieldset',
    '#title'        => t('Node display settings'),
    '#description'     => t("Options for displaying or hiding post information for your site's content. For example you may wish to show the author and date for Blog posts and hide these options for info pages."),
    '#collapsible'     => TRUE,
    '#collapsed'     => TRUE,
    '#attributes'     => array('class' => 'node_settings'),
  );
  
  // Author & Date Settings
  $form['node_specific_settings']['post_info_container'] = array(
    '#type'         => 'fieldset',
    '#title'         => t('Author & date'),
    '#collapsible'     => TRUE,
    '#collapsed'     => TRUE,
  );
  // Default & content-type specific settings
  if (!module_exists('submitted_by')) {
    foreach ( array_merge(array('default' => 'Default'), node_get_types('names')) as $type => $name) {
      $form['node_specific_settings']['post_info_container']['submitted_by'][$type] = array(
        '#type'         => 'fieldset',
        '#title'         => t('!name', array('!name' => t($name))),
        '#collapsible'     => TRUE,
        '#collapsed'     => TRUE,
      );
      $form['node_specific_settings']['post_info_container']['submitted_by'][$type]["submitted_by_author_{$type}"] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Display author\'s username'),
        '#default_value' => $settings["submitted_by_author_{$type}"],
      );
      $form['node_specific_settings']['post_info_container']['submitted_by'][$type]["submitted_by_date_{$type}"] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Display date posted'),
        '#default_value' => $settings["submitted_by_date_{$type}"],
      );
      // Options for default settings
      if ($type == 'default') {
        $form['node_specific_settings']['post_info_container']['submitted_by']['default']['#title'] = t('Default');
        $form['node_specific_settings']['post_info_container']['submitted_by']['default']['#collapsed'] = $settings['submitted_by_content_type'] ? TRUE : FALSE;
        $form['node_specific_settings']['post_info_container']['submitted_by']['submitted_by_content_type'] = array(
          '#type'          => 'checkbox',
          '#title'         => t('Use custom settings for each content type instead of the default above'),
          '#default_value' => $settings['submitted_by_content_type'],
        );
      }
      // Collapses content-type specific settings if default settings are being used
      else if ($settings['submitted_by_content_type'] == 0) {
        $form['submitted_by'][$type]['#collapsed'] = TRUE;
      }
    }
  } 
  else {
      $form['node_specific_settings']['post_info_container']['#description'] = 'NOTICE: You currently have the "Submitted By" module installed and enabled, so the Author & Date theme settings have been disabled to prevent conflicts.  If you wish to re-enable the Author & Date theme settings, you must first disable the "Submitted By" module.';
  }
      
  // Read More & Comment Link Settings
  $form['node_specific_settings']['link_settings_container'] = array(
    '#type'        => 'fieldset',
    '#title'       => t('Links'),
    '#description' => t('Define custom text for node links'),
    '#collapsible' => TRUE,
    '#collapsed'   => TRUE,
  );
  
  // Read more link settings
  $form['node_specific_settings']['link_settings_container']['readmore'] = array(
    '#type'        => 'fieldset',
    '#title'       => t('Read more link'),
    '#collapsible' => TRUE,
    '#collapsed'   => TRUE,
  );
  // Default & content-type specific settings
  foreach ( array_merge(array('default' => 'Default'), node_get_types('names')) as $type => $name) {
    // Read more
    $form['node_specific_settings']['link_settings_container']['readmore'][$type] = array(
      '#type'        => 'fieldset',
      '#title'       => t('!name', array('!name' => t($name))),
      '#collapsible' => TRUE,
      '#collapsed'   => TRUE,
    );
    $form['node_specific_settings']['link_settings_container']['readmore'][$type]["readmore_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Link text'),
      '#default_value' => $settings["readmore_{$type}"],
      '#description'   => t('HTML is allowed.'),
    );
    $form['node_specific_settings']['link_settings_container']['readmore'][$type]["readmore_title_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Title text (tool tip)'),
      '#default_value' => $settings["readmore_title_{$type}"],
      '#description'   => t('Displayed when hovering over link. Plain text only.'),
    );
    $form['node_specific_settings']['link_settings_container']['readmore'][$type]["readmore_prefix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Prefix'),
      '#default_value' => $settings["readmore_prefix_{$type}"],
      '#description'   => t('Text or HTML placed before the link.'),
    );
    $form['node_specific_settings']['link_settings_container']['readmore'][$type]["readmore_suffix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Suffix'),
      '#default_value' => $settings["readmore_suffix_{$type}"],
      '#description'   => t('Text or HTML placed after the link.'),
    );
    // Options for default settings
    if ($type == 'default') {
      $form['node_specific_settings']['link_settings_container']['readmore']['default']['#title'] = t('Default');
      $form['node_specific_settings']['link_settings_container']['readmore']['default']['#collapsed'] = $settings['readmore_content_type'] ? TRUE : FALSE;
      $form['node_specific_settings']['link_settings_container']['readmore']['readmore_content_type'] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Use custom settings for each content type instead of the default above'),
        '#default_value' => $settings['readmore_content_type'],
      );
    }
    // Collapses content-type specific settings if default settings are being used
    else if ($settings['readmore_content_type'] == 0) {
      $form['readmore'][$type]['#collapsed'] = TRUE;
    }
  }
  // Comments link settings
  $form['node_specific_settings']['link_settings_container']['comment'] = array(
    '#type'        => 'fieldset',
    '#title'       => t('Comment links setting'),
    '#collapsible' => TRUE,
    '#collapsed'   => TRUE,
  );
  // Default & content-type specific settings
  foreach ( array_merge(array('default' => 'Default'), node_get_types('names')) as $type => $name) {
    $form['node_specific_settings']['link_settings_container']['comment'][$type] = array(
      '#type'        => 'fieldset',
      '#title'       => t('!name', array('!name' => t($name))),
      '#collapsible' => TRUE,
      '#collapsed'   => TRUE,
    );
    // Full nodes
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['node'] = array(
      '#type'        => 'fieldset',
      '#title'       => t('Full node view settings'),
      '#collapsible' => TRUE,
      '#collapsed'   => TRUE,
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['node']['add'] = array(
      '#type'        => 'fieldset',
      '#title'       => t('"Add new comment" link'),
      '#description' => t('The link when the full content is being displayed.'),
      '#collapsible' => TRUE,
      '#collapsed'   => TRUE,
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['node']['add']["comment_node_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Link text'),
      '#default_value' => $settings["comment_node_{$type}"],
      '#description'   => t('HTML is allowed.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['node']['add']["comment_node_title_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Title text (tool tip)'),
      '#default_value' => $settings["comment_node_title_{$type}"],
      '#description'   => t('Displayed when hovering over link. Plain text only.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['node']['add']["comment_node_prefix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Prefix'),
      '#default_value' => $settings["comment_node_prefix_{$type}"],
      '#description'   => t('Text or HTML placed before the link.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['node']['add']["comment_node_suffix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Suffix'),
      '#default_value' => $settings["comment_node_suffix_{$type}"],
      '#description'   => t('Text or HTML placed after the link.'),
    );
    // Teasers
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser'] = array(
      '#type'        => 'fieldset',
      '#title'       => t('Teasers view settings'),
      '#collapsible' => TRUE,
      '#collapsed'   => TRUE,
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['add'] = array(
      '#type'        => 'fieldset',
      '#title'       => t('"Add new comment" link'),
      '#description' => t('The link when there are no comments.'),
      '#collapsible' => TRUE,
      '#collapsed'   => TRUE,
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['add']["comment_add_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Link text'),
      '#default_value' => $settings["comment_add_{$type}"],
      '#description'   => t('HTML is allowed.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['add']["comment_add_title_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Title text (tool tip)'),
      '#default_value' => $settings["comment_add_title_{$type}"],
      '#description'   => t('Displayed when hovering over link. Plain text only.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['add']["comment_add_prefix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Prefix'),
      '#default_value' => $settings["comment_add_prefix_{$type}"],
      '#description'   => t('Text or HTML placed before the link.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['add']["comment_add_suffix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Suffix'),
      '#default_value' => $settings["comment_add_suffix_{$type}"],
      '#description'   => t('Text or HTML placed after the link.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['standard'] = array(
      '#type'        => 'fieldset',
      '#title'       => t('"Comments" link'),
      '#description' => t('The link when there are one or more comments.'),
      '#collapsible' => TRUE,
      '#collapsed'   => TRUE,
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['standard']["comment_singular_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Link text when there is 1 comment'),
      '#default_value' => $settings["comment_singular_{$type}"],
      '#description'   => t('HTML is allowed.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['standard']["comment_plural_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Link text when there are multiple comments'),
      '#default_value' => $settings["comment_plural_{$type}"],
      '#description'   => t('HTML is allowed. @count will be replaced with the number of comments.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['standard']["comment_title_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Title text (tool tip)'),
      '#default_value' => $settings["comment_title_{$type}"],
      '#description'   => t('Displayed when hovering over link. Plain text only.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['standard']["comment_prefix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Prefix'),
      '#default_value' => $settings["comment_prefix_{$type}"],
      '#description'   => t('Text or HTML placed before the link.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['standard']["comment_suffix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Suffix'),
      '#default_value' => $settings["comment_suffix_{$type}"],
      '#description'   => t('Text or HTML placed after the link.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['new'] = array(
      '#type'        => 'fieldset',
      '#title'       => t('"New comments" link'),
      '#description' => t('The link when there are one or more new comments.'),
      '#collapsible' => TRUE,
      '#collapsed'   => TRUE,
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['new']["comment_new_singular_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Link text when there is 1 new comment'),
      '#default_value' => $settings["comment_new_singular_{$type}"],
      '#description'   => t('HTML is allowed.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['new']["comment_new_plural_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Link text when there are multiple new comments'),
      '#default_value' => $settings["comment_new_plural_{$type}"],
      '#description'   => t('HTML is allowed. @count will be replaced with the number of comments.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['new']["comment_new_title_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Title text (tool tip)'),
      '#default_value' => $settings["comment_new_title_{$type}"],
      '#description'   => t('Displayed when hovering over link. Plain text only.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['new']["comment_new_prefix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Prefix'),
      '#default_value' => $settings["comment_new_prefix_{$type}"],
      '#description'   => t('Text or HTML placed before the link.'),
    );
    $form['node_specific_settings']['link_settings_container']['comment'][$type]['teaser']['new']["comment_new_suffix_{$type}"] = array(
      '#type'          => 'textfield',
      '#title'         => t('Suffix'),
      '#default_value' => $settings["comment_new_suffix_{$type}"],
      '#description'   => t('Text or HTML placed after the link.'),
    );
    // Options for default settings
    if ($type == 'default') {
      $form['node_specific_settings']['link_settings_container']['comment']['default']['#title'] = t('Default');
      $form['node_specific_settings']['link_settings_container']['comment']['default']['#collapsed'] = $settings['comment_content_type'] ? TRUE : FALSE;
      $form['node_specific_settings']['link_settings_container']['comment']['comment_content_type'] = array(
        '#type'          => 'checkbox',
        '#title'         => t('Use custom settings for each content type instead of the default above'),
        '#default_value' => $settings['comment_content_type'],
      );
    }
    // Collapses content-type specific settings if default settings are being used
    else if ($settings['comment_content_type'] == 0) {
      $form['comment'][$type]['#collapsed'] = TRUE;
    }
  }    
  
  
  // Taxonomy Settings
  if (module_exists('taxonomy')) {
    $form['node_specific_settings']['taxonomy_settings_container'] = array(
      '#type' => 'fieldset',
      '#title' => t('Taxonomy terms'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );
    // Default & content-type specific settings
    foreach ( array_merge(array('default' => 'Default'), node_get_types('names')) as $type => $name) {
      // taxonomy display per node
      $form['node_specific_settings']['taxonomy_settings_container']['display_taxonomy'][$type] = array(
        '#type' => 'fieldset',
        '#title'       => t('!name', array('!name' => t($name))),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
      );
      // display
      $form['node_specific_settings']['taxonomy_settings_container']['display_taxonomy'][$type]["taxonomy_display_{$type}"] = array(
        '#type'          => 'select',
        '#title'         => t('When should taxonomy terms be displayed?'),
        '#default_value' => $settings["taxonomy_display_{$type}"],
        '#options'       => array(
                              '' => '',
                              'never' => t('Never display taxonomy terms'),
                              'all' => t('Always display taxonomy terms'),
                              'only' => t('Only display taxonomy terms on full node pages'),
                            ),
      );
      // format
      $form['node_specific_settings']['taxonomy_settings_container']['display_taxonomy'][$type]["taxonomy_format_{$type}"] = array(
        '#type'          => 'radios',
        '#title'         => t('Taxonomy display format'),
        '#default_value' => $settings["taxonomy_format_{$type}"],
        '#options'       => array(
                              'vocab' => t('Display each vocabulary on a new line'),
                              'list' => t('Display all taxonomy terms together in single list'),
                            ),
      );
      // Gets taxonomy vocabularies by node type
      $vocabs = array();
      $vocabs_by_type = ($type == 'default') ? taxonomy_get_vocabularies() : taxonomy_get_vocabularies($type);
      foreach ($vocabs_by_type as $key => $value) {
        $vocabs[$value->vid] = $value->name;
      }
      // Displays taxonomy checkboxes
      foreach ($vocabs as $key => $vocab_name) {
        $form['node_specific_settings']['taxonomy_settings_container']['display_taxonomy'][$type]["taxonomy_vocab_hide_{$type}_{$key}"] = array(
          '#type'          => 'checkbox',
          '#title'         => t('Hide vocabulary: '. $vocab_name),
          '#default_value' => $settings["taxonomy_vocab_hide_{$type}_{$key}"], 
        );
      }
      // Options for default settings
      if ($type == 'default') {
        $form['node_specific_settings']['taxonomy_settings_container']['display_taxonomy']['default']['#title'] = t('Default');
        $form['node_specific_settings']['taxonomy_settings_container']['display_taxonomy']['default']['#collapsed'] = $settings['taxonomy_enable_content_type'] ? TRUE : FALSE;
        $form['node_specific_settings']['taxonomy_settings_container']['display_taxonomy']['taxonomy_enable_content_type'] = array(
          '#type'          => 'checkbox',
          '#title'         => t('Use custom settings for each content type instead of the default above'),
          '#default_value' => $settings['taxonomy_enable_content_type'],
        );
      }
      // Collapses content-type specific settings if default settings are being used
      else if ($settings['taxonomy_enable_content_type'] == 0) {
        $form['display_taxonomy'][$type]['#collapsed'] = TRUE;
      }
    }
  }
  // Username display settings
  $form['username'] = array(
    '#type' => 'fieldset',
    '#title' => t('Username'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['username']['user_notverified_display'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display "not verified" for unregistered usernames'),
    '#default_value' => $settings['user_notverified_display'],
  );
  

  // Block editing settings
  $form['block_settings'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Block editing settings'),
    '#collapsible'   => TRUE,
    '#collapsed'     => TRUE,
  );

  $form['block_settings']['block_editing_link'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show block editing links on hover'),
    '#description'   => t('When hovering over a block, privileged users will see block editing links.'),
    '#default_value' => $settings['block_editing_link'],
  );


  // Breadcrumb display settings
  $form['breadcrumb'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Breadcrumb settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['breadcrumb']['breadcrumb'] = array(
    '#type'          => 'radios',
    '#title'         => t('Display breadcrumb'),
    '#default_value' => $settings['breadcrumb'],
    '#options'       => array(
      'yes'   => t('Yes'),
      'no'    => t('No'),
      'admin' => t('Only in admin section'),
    ),
  );
  $form['breadcrumb']['breadcrumb_separator'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Breadcrumb separator'),
    '#description'   => t('Text only. Don’t forget to include spaces.'),
    '#default_value' => $settings['breadcrumb_separator'],
    '#size'          => 5,
    '#maxlength'     => 10,
  );
  $form['breadcrumb']['breadcrumb_home_link'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show home page link in breadcrumb'),
    '#default_value' => $settings['breadcrumb_home_link'],
  );
  $form['breadcrumb']['breadcrumb_trailing_separator'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append a separator to the end of the breadcrumb'),
    '#default_value' => $settings['breadcrumb_trailing_separator'],
    '#description'   => t('Useful when the breadcrumb is placed just before the title.'),
  );
  $form['breadcrumb']['breadcrumb_title'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append the content title to the end of the breadcrumb'),
    '#default_value' => $settings['breadcrumb_title'],
    '#description'   => t('Useful when the breadcrumb is not placed just before the title.'),
  );

  // Development phase settings
  $form['theme_development'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Theme development settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['theme_development']['rebuild_registry'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Rebuild theme registry on every page.'),
    '#default_value' => $settings['rebuild_registry'],
    '#description'   => t('During theme development, it can be very useful to continuously <a href="!link">rebuild the theme registry</a>. WARNING: this is a huge performance penalty and must be turned off on production websites.', array('!link' => 'http://drupal.org/node/173880#theme-registry')),
    '#prefix'        => '<strong>'. t('Theme registry:') .'</strong>',
  );

  return $form;
}