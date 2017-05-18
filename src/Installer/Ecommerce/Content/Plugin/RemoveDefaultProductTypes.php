<?php

namespace Drupal\presto\Installer\Ecommerce\Content\Plugin;

use Drupal\commerce_product\Entity\ProductType;
use Drupal\commerce_product\Entity\ProductVariationType;

/**
 * Removes the default product types as we create our own.
 *
 * @PrestoEcommerceDemoContent(
 *     id = "remove_default_products",
 *     label = @Translation("Remove default product types"),
 *     weight = 0
 * )
 *
 * @package Drupal\presto\Installer\Ecommerce\Content\Plugin
 */
class RemoveDefaultProductTypes extends AbstractDemoContent {

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function createContent() {
    $defaultProductVariationType = ProductVariationType::load('default');
    if ($defaultProductVariationType !== NULL) {
      $defaultProductVariationType->delete();
    }

    $defaultProductType = ProductType::load('default');
    if ($defaultProductType !== NULL) {
      $defaultProductType->delete();
    }
  }

}
