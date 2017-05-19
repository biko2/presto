<?php

/**
 * Implements hook_form_system_theme_settings_alter()
 */
// function presto_theme_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface &$form_state, $form_id = NULL) {
//   // Work-around for a core bug affecting admin themes. See issue #943212.
//   if (isset($form_id)) {
//     return;
//   }

//   $form['presto_theme_browsersync_enable'] = array(
//     '#type' => 'checkbox',
//     '#title' => t('Enable Browsersync'),
//     '#default_value' => theme_get_setting('presto_theme_browsersync_enable'),
//   );

//   $form['presto_theme_browsersync_url'] = array(
//     '#type' => 'textfield',
//     '#title' => t('Browsersync URL'),
//     '#default_value' => theme_get_setting('presto_theme_browsersync_url'),
//   );
// }
