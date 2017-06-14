<?php

namespace Drupal\presto\Installer\OptionalDependencies;

use Drupal\presto\Installer\InstallerInterface;

/**
 * Installs optional dependencies.
 *
 * @package Drupal\presto\Installer\OptionalDependencies
 */
class OptionalDependenciesInstaller implements InstallerInterface {

  // Key in the install state that optional dependency config is stored in.
  const CONFIG_KEY = 'optional_dependencies';

  /**
   * The Drupal install state.
   *
   * @var array
   */
  private $installState;

  /**
   * The optional dependency manager.
   *
   * @var \Drupal\presto\Installer\OptionalDependencies\OptionalDependencyManager
   */
  private $optionalDependencyManager;

  /**
   * OptionalDependenciesInstaller constructor.
   *
   * @param \Drupal\presto\Installer\OptionalDependencies\OptionalDependencyManager $manager
   *   The optional dependency manager.
   * @param array $installState
   *   The Drupal install state.
   */
  public function __construct(
    OptionalDependencyManager $manager,
    array $installState = []
  ) {
    $this->optionalDependencyManager = $manager;
    $this->installState = $installState;
  }

  /**
   * {@inheritdoc}
   */
  public function setInstallState(array $installState) {
    $this->installState = $installState;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function installIfEnabled() {
    $operations = [];

    $dependencies = $this->optionalDependencyManager->getDefinitions();

    foreach ($dependencies as $dependency) {
      /** @var \Drupal\presto\Installer\OptionalDependencies\OptionalDependencyInterface $instance */
      $instance = $this->optionalDependencyManager->createInstance(
        $dependency['id'],
        $this->getPluginConfig($dependency['id'])
      );

      if ($instance->shouldInstall($this->installState)) {
        $operations[] = $instance->getInstallOperations();
      }
    }

    // Prevent a greedy array_merge (argument unpacking not used for PHP 5.5
    // support).
    if (count($operations) > 0) {
      /** @noinspection ArgumentUnpackingCanBeUsedInspection */
      $operations = call_user_func_array('array_merge', $operations);
    }

    return $operations;
  }

  /**
   * Get plugin config from the install state.
   *
   * @param string $pluginId
   *   Plugin ID.
   *
   * @return array
   *   Plugin config (if any).
   */
  private function getPluginConfig($pluginId) {
    if (!array_key_exists(static::CONFIG_KEY, $this->installState)) {
      return [];
    }

    if (!array_key_exists($pluginId, $this->installState[static::CONFIG_KEY])) {
      return [];
    }

    return $this->installState[static::CONFIG_KEY][$pluginId];
  }

}
