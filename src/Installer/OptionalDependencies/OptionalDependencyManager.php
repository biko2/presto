<?php

namespace Drupal\presto\Installer\OptionalDependencies;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\presto\Annotation\PrestoOptionalDependency;
use Drupal\presto\Mixins\WeightedPluginManagerTrait;
use Traversable;

/**
 * Class OptionalDependenciesManager.
 *
 * @package Drupal\presto\Installer\OptionalDependencies
 */
class OptionalDependencyManager extends DefaultPluginManager {

  use WeightedPluginManagerTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    Traversable $namespaces,
    CacheBackendInterface $cacheBackend,
    ModuleHandlerInterface $moduleHandler
  ) {
    parent::__construct(
      'Plugin/Presto/OptionalDependency',
      $namespaces,
      $moduleHandler,
      OptionalDependencyInterface::class,
      PrestoOptionalDependency::class
    );

    $this->alterInfo('presto_ecommerce_optional_dependency_info');
    $this->setCacheBackend(
      $cacheBackend,
      'presto_ecommerce_optional_dependency'
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    $definitions = parent::getDefinitions();
    return $this->sortByWeight($definitions);
  }

}
