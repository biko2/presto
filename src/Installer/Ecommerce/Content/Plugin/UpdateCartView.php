<?php

namespace Drupal\presto\Installer\Ecommerce\Content\Plugin;

use Drupal;
use Drupal\Core\Config\FileStorage;

/**
 * Override the cart views.
 *
 * @PrestoEcommerceDemoContent(
 *     id = "update_cart_view",
 *     label = @Translation("Update Cart Views"),
 *     weight = 1
 * )
 *
 * @package Drupal\presto\Installer\Ecommerce\Content\Plugin
 */
class UpdateCartView extends AbstractDemoContent {

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Config\UnsupportedDataTypeConfigException
   */
  public function createContent() {
    $modulePath = drupal_get_path('module', 'presto_commerce');
    $configPath = "{$modulePath}/config/optional";

    $source = new FileStorage($configPath);

    // Re-read view order commerce checkout summary.
    // This should be safe enough as this only runs within a site install
    // context.
    $configStorage = Drupal::service('config.storage');
    $configStorage->write(
      'views.view.commerce_checkout_order_summary',
      $source->read('views.view.commerce_checkout_order_summary')
    );
  }

}
