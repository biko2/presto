<?php

namespace Drupal\presto\Installer\Ecommerce\Content;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\presto\Annotation\PrestoEcommerceDemoContent;
use Drupal\presto\Installer\Ecommerce\Content\Plugin\AbstractDemoContent;

/**
 * Class Manager.
 *
 * Creates demo content using demo content creation plugins.
 *
 * @package Drupal\presto\Installer\Ecommerce\Content
 */
class Manager extends DefaultPluginManager {

  /**
   * Manager constructor.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cacheBackend
   *   Cache backend to use to cache plugin definitions.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler.
   */
  public function __construct(
    \Traversable $namespaces,
    CacheBackendInterface $cacheBackend,
    ModuleHandlerInterface $moduleHandler
  ) {
    parent::__construct(
      'Installer/Ecommerce/Content/Plugin',
      $namespaces,
      $moduleHandler,
      AbstractDemoContent::class,
      PrestoEcommerceDemoContent::class
    );

    $this->alterInfo('presto_ecommerce_demo_content_info');
    $this->setCacheBackend(
      $cacheBackend,
      'presto_ecommerce_demo_content'
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    $definitions = parent::getDefinitions();

    // Sort definitions by weight before returning.
    uasort($definitions, function ($first, $second) {
      if ($first['weight'] === $second['weight']) {
        return 0;
      }
      return ($first['weight'] < $second['weight']) ? -1 : 1;
    });

    return $definitions;
  }

}
