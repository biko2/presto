<?php

namespace Drupal\presto\Installer;

/**
 * Interface InstallerInterface.
 *
 * @package Drupal\presto\Installer
 */
interface InstallerInterface {

  /**
   * Sets up all install tasks if they're enabled.
   *
   * @return array
   *   A batch operations definition with all enabled install tasks.
   */
  public function installIfEnabled();

}
