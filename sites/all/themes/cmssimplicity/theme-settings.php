<?php  
// $Id$
/**
 * @file
 * theme-settings.php
 */
include_once './'. drupal_get_path('theme', 'cms_base') .'/theme-settings.php';


/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array. 
 */
function cmssimplicity_settings($saved_settings) {
  $form = array();
  // Get the default values from the .info file.
  $defaults = cms_base_default_settings('cmssimplicity');
  $settings = array_merge($defaults, $saved_settings);

  // Add the base theme's settings.
  $form += cms_base_settings($saved_settings, $defaults);

  $form['layout']['theme_color_style'] = array(
    '#type' => 'select',
    '#title' => t('Color/Style'),
    '#default_value' => $settings['theme_color_style'],
    '#options' => array(
      'blue' => t('Blue'),
      'orange' => t('Orange'),
      'red' => t('Red'),
      'yellow' => t('Yellow'),
      'green' => t('Green')
    ),
  );

  $form['layout']['theme_background'] = array(
    '#type' => 'select',
    '#title' => t('Background'),
    '#default_value' => $settings['theme_background'],
    '#options' => array(
    'full-blue' => t('Full Blue'),
    'blue-ends' => t('Blue Ends'),
    'full-dark' => t('Full Dark'),
    'dark-ends' => t('Dark Ends'),
    'full-green' => t('Full Green'),
    'green-ends' => t('Green Ends'),
    'full-purple' => t('Full Purple'),
    'purple-ends' => t('Purple Ends'),
    'full-red' => t('Full Red'),
    'red-ends' => t('Red Ends')
    ),
  );

  // Return the form 
  return $form;
}