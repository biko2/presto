<?php

namespace Drupal\presto\Installer\OptionalDependencies;

use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * Defines a new optional dependency.
 *
 * @package Drupal\presto\Installer\OptionalDependencies
 */
interface OptionalDependencyInterface extends
    PluginFormInterface,
    ConfigurablePluginInterface {

  /**
   * Checks if this dependency should be installed.
   *
   * @param array $installState
   *   The current Drupal install state.
   *
   * @return bool
   *   TRUE if this dependency should be installed, FALSE otherwise.
   */
  public function shouldInstall(array $installState);

  /**
   * Get any required Batch API install operations for this dependency.
   *
   * @return array
   *   Batch operation definitions.
   */
  public function getInstallOperations();

}
