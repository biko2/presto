<?php

namespace Drupal\presto\Mixins;

use Drupal;
use Drupal\presto\Installer\DependencyTypes;
use Drupal\presto\Installer\InstallerException;

/**
 * Adds helpers to handle module/theme installs in a Batch API context.
 *
 * @package Drupal\presto\Mixins
 */
trait DrupalDependencyInstallerTrait {

  /**
   * Installs a Drupal dependency (e.g. a module or a theme).
   *
   * This is a Drupal batch callback operation and as such, needs to be both a
   * public and a static function so that the Batch API can access it outside
   * the context of this class.
   *
   * @param string $dependency
   *   Dependency machine name.
   * @param string $type
   *   Dependency type.
   * @param array $context
   *   Batch API context.
   *
   * @throws \Drupal\Core\Extension\ExtensionNameLengthException
   * @throws \Drupal\Core\Extension\MissingDependencyException
   * @throws \Drupal\presto\Installer\InstallerException
   */
  public static function installDependency($dependency, $type, array &$context) {
    // Reset time limit so we don't timeout.
    drupal_set_time_limit(0);

    switch ($type) {
      case DependencyTypes::MODULE:
        /** @var \Drupal\Core\Extension\ModuleInstaller $moduleInstaller */
        $moduleInstaller = Drupal::service('module_installer');
        $moduleInstaller->install([$dependency]);
        break;

      case DependencyTypes::THEME:
        /** @var \Drupal\Core\Extension\ThemeInstaller $themeInstaller */
        $themeInstaller = Drupal::service('theme_installer');
        $themeInstaller->install([$dependency]);
        break;

      default:
        throw new InstallerException(
          "Unknown dependency type '{$type}'."
        );
    }

    $context['results'][] = $dependency;
    $context['message'] = t(
      'Installed @dependency_type %dependency.',
      [
        '@dependency_type' => $type,
        '%dependency' => $dependency,
      ]
    );
  }

}
