<?php

namespace Drupal\presto\Installer;

/**
 * Defines a new demo content item.
 *
 * @package Drupal\presto\Installer
 */
interface DemoContentInterface {

  /**
   * Creates a piece of demo content.
   */
  public function createContent();

}
