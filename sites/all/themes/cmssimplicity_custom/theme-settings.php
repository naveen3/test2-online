<?php  
// $Id$
/**
 * @file
 * theme-settings.php
 */
// Include the definition of cmssimplicity_settings() and zen_theme_get_default_settings().
include_once './'. drupal_get_path('theme', 'cmssimplicity') .'/theme-settings.php';

 
/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array. 
 */
function cmssimplicity_custom_settings($saved_settings) {
  $form = array();
  // Get the default values from the .info file.
  $defaults = cms_base_default_settings('cmssimplicity_custom');
  $settings = array_merge($defaults, $saved_settings);

  // Add the base theme's settings.
  $form += cmssimplicity_settings($saved_settings, $defaults);

  // Return the form 
  return $form;
}