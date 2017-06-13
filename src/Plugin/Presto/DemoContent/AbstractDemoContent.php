<?php

namespace Drupal\presto\Plugin\Presto\DemoContent;

use Drupal;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\PluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AbstractDemoContent.
 *
 * Sets up base functionality for demo content creation plugins.
 *
 * @package Drupal\presto\Plugin\Presto\DemoContent
 */
abstract class AbstractDemoContent extends PluginBase implements
    ContainerFactoryPluginInterface {

  /**
   * Entity manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * AbstractDemoContent constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity manager.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entityTypeManager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
   * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    /** @var \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager */
    $entityTypeManager = $container->get('entity_type.manager');
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $entityTypeManager
    );
  }

  /**
   * Loads the main store.
   *
   * @return int
   *   Loaded store ID or NULL if one couldn't be found.
   */
  protected function loadStoreId() {
    $query = Drupal::entityQuery('commerce_store');
    $result = $query->execute();

    // There should only ever be one value returned so we naively use the first
    // item in the array. This should generally be safe as this should only run
    // within a Drupal site install context.
    $storeId = NULL;
    if (count($result) > 0) {
      $storeId = reset($result);
    }

    return $storeId;
  }

  /**
   * Creates a piece of demo content.
   */
  abstract public function createContent();

}
