<?php

namespace Drupal\presto\Installer;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\presto\Annotation\PrestoDemoContent;
use Drupal\presto\Mixins\WeightedPluginManagerTrait;
use Traversable;

/**
 * Creates demo content using demo content creation plugins.
 *
 * @package Drupal\presto\Installer
 */
class DemoContentManager extends DefaultPluginManager {

  use WeightedPluginManagerTrait;

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
    Traversable $namespaces,
    CacheBackendInterface $cacheBackend,
    ModuleHandlerInterface $moduleHandler
  ) {
    parent::__construct(
      'Plugin/Presto/DemoContent',
      $namespaces,
      $moduleHandler,
      DemoContentInterface::class,
      PrestoDemoContent::class
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
    return $this->sortByWeight($definitions);
  }

  /**
   * Filters plugin definitions by a type.
   *
   * @param string $type
   *   Type to filter by.
   *
   * @return array
   *   A list of filtered plugin definitions.
   */
  public function getFilteredDefinitions($type) {
    $all = $this->getDefinitions();

    return array_filter($all, function ($definition) use ($type) {
      return $definition['type'] === $type;
    });
  }

}
