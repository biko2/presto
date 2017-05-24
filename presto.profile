<?php

/**
 * @file
 * The Presto profile.
 */

/**
 * Implements hook_preprocess_views_view().
 */
function presto_preprocess_views_view(&$variables) {
  $mediaBrowser = [
    'media_browser_dropzone',
  ];

  if (in_array($variables['view']->id(), $mediaBrowser, true)) {
    $variables['view_array']['#attached']['library'][] =
      'presto/entity_browser_view';
  }
}

/**
 * Implements hook_page_attachments().
 */
function presto_page_attachments(array &$page) {
  $page['#attached']['library'][] = 'presto/entity_browser_view';
}
