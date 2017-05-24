<?php

namespace Drupal\presto\Composer;

use Drupal\presto\IniEncoder;
use Composer\Package\PackageInterface;
use Composer\Script\Event;
use Composer\Util\ProcessExecutor;
use Symfony\Component\Yaml\Yaml;

/**
 * Generates Drush make files, heavily inspired by acquia/lightning.
 *
 * Based on code by Acquia in acquia/lightning, copyright (c) 2017.
 * Distributed under the GNU GPL v2 or higher. For full terms see the LICENSE
 * file.
 */
class Package {

  // The name of the property under 'extra' in composer.json that stores asset
  // overrides.
  const ASSET_OVERRIDE_PROP = 'asset-library-overrides';

  /**
   * Main entry point for command.
   *
   * @param \Composer\Script\Event $event
   *   Composer event.
   *
   * @throws \RuntimeException
   */
  public static function execute(Event $event) {
    $composer = $event->getComposer();
    $encoder = new IniEncoder();

    // Convert the lock file to a make file using Drush's make-convert command.
    $binDir = $composer->getConfig()->get('bin-dir');
    $make = NULL;
    $executor = new ProcessExecutor();
    $executor->execute($binDir . '/drush make-convert composer.lock', $make);
    $make = Yaml::parse($make);

    // Include any drupal-library packages in the make file.
    $libraries = $composer
      ->getRepositoryManager()
      ->getLocalRepository()
      ->getPackages();
    $libraries = array_filter($libraries, function (PackageInterface $package) {
      return $package->getType() === 'drupal-library';
    });

    // Drop the vendor prefixes.
    foreach ($libraries as $library) {
      $oldKey = $library->getName();
      $newKey = basename($oldKey);
      $make['libraries'][$newKey] = $make['libraries'][$oldKey];
      unset($make['libraries'][$oldKey]);
    }

    // Check for any asset library overrides and apply if so. Also drop the
    // vendor name from the library.
    if (array_key_exists('libraries', $make)) {
      /** @var array[] $overrides */
      $overrides = $composer->getPackage()->getExtra();

      if (array_key_exists(static::ASSET_OVERRIDE_PROP, $overrides)) {
        /** @var array $override */
        foreach ($overrides[static::ASSET_OVERRIDE_PROP] as $libraryName => $override) {
          // Skip unsupported packages.
          if (!array_key_exists($libraryName, $make['libraries'])) {
            continue;
          }

          // If a key doesn't exist, generate one by stripping out the vendor
          // prefix.
          if (!array_key_exists('key', $override)) {
            $key = basename($libraryName);
          } else {
            $key = $override['key'];
            unset($override['key']);
          }

          $makeDef = $make['libraries'][$libraryName];
          unset($make['libraries'][$libraryName]);
          $make['libraries'][$key] = $makeDef;

          // Apply all overrides.
          foreach ($override as $overrideKey => $overrideValue) {
            $make['libraries'][$key][$overrideKey] = $overrideValue;
          }
        }
      }
    }

    if (isset($make['projects']['drupal'])) {
      // Always use drupal.org's core repository, or patches will not apply.
      $make['projects']['drupal']['download']['url'] = 'https://git.drupal.org/project/drupal.git';
      $core = [
        'api' => 2,
        'core' => '8.x',
        'projects' => [
          'drupal' => [
            'type' => 'core',
            'version' => $make['projects']['drupal']['download']['tag'],
          ],
        ],
      ];
      if (isset($make['projects']['drupal']['patch'])) {
        $core['projects']['drupal']['patch'] = $make['projects']['drupal']['patch'];
      }
      file_put_contents('drupal-org-core.make', $encoder->encode($core));
      unset($make['projects']['drupal']);
    }

    foreach ($make['projects'] as &$project) {
      if ($project['download']['type'] === 'git') {
        if (!array_key_exists('tag', $project['download'])) {
          $tag = "{$project['download']['branch']}-dev";
        }
        else {
          $tag = $project['download']['tag'];
          preg_match('/\d+\.x-\d+\.0/', $tag, $match);
          $tag = str_replace($match, str_replace('x-', NULL, $match), $tag);
          preg_match('/\d+\.\d+\.0/', $tag, $match);
          $tag = str_replace($match, substr($match[0], 0, -2), $tag);
        }

        $project['version'] = $tag;
        unset($project['download']);
      }
    }
    file_put_contents('drupal-org.make', $encoder->encode($make));
  }

}
