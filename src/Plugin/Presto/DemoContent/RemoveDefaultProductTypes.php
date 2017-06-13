<?php

namespace Drupal\presto\Plugin\Presto\DemoContent;

use Drupal\commerce_product\Entity\ProductType;
use Drupal\commerce_product\Entity\ProductVariationType;

/**
 * Removes the default product types as we create our own.
 *
 * @PrestoDemoContent(
 *     id = "remove_default_products",
 *     type = \Drupal\presto\Installer\DemoContentTypes::ECOMMERCE,
 *     label = @Translation("Remove default product types"),
 *     weight = 0
 * )
 *
 * @package Drupal\presto\Plugin\Presto\DemoContent
 */
class RemoveDefaultProductTypes extends AbstractDemoContent {

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function createContent() {
    $productVariationType = ProductVariationType::load('default');
    if ($productVariationType !== NULL) {
      $productVariationType->delete();
    }

    $defaultProductType = ProductType::load('default');
    if ($defaultProductType !== NULL) {
      $defaultProductType->delete();
    }
  }

}
