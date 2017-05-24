<?php

namespace Drupal\presto\Installer\Ecommerce\Content\Plugin;

use Drupal;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_product\Entity\ProductAttributeValue;
use Drupal\commerce_product\Entity\ProductVariation;

/**
 * Base class for all product creating classes.
 *
 * @package Drupal\presto\Installer\Ecommerce\Content\Plugin
 */
abstract class AbstractBaseProductCreator extends AbstractDemoContent {

  /**
   * Defines product details.
   *
   * @return array
   *   An array with the following keys:
   *    - type
   *    - title
   *    - description
   */
  abstract protected function productDetails();

  /**
   * Defines product variations.
   *
   * @return array[]
   *   An of product variation definitions.
   */
  abstract protected function productVariations();

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function createContent() {
    $productDetails = $this->productDetails();

    /** @var \Drupal\commerce_product\Entity\Product $product */
    $product = Product::create($productDetails);
    $product->save();

    foreach ($this->productVariations() as $variationAttrs) {
      $variationAttrs['product_id'] = $product->id();
      $variation = ProductVariation::create($variationAttrs);
      $variation->save();
      $product->addVariation($variation);
    }

    $storeId = $this->loadStoreId();
    if ($storeId !== NULL) {
      $product->setStoreIds([$storeId]);
    }

    $product->save();
  }

  /**
   * Loads a product attribute value by attribute ID and name.
   *
   * @param string $name
   *   Attribute value name.
   * @param string $attribute
   *   Attribute ID.
   *
   * @return \Drupal\commerce_product\Entity\ProductAttributeValue|null
   *   Loaded attribute value or NULL if one couldn't be found.
   */
  protected function loadAttributeValue($name, $attribute) {
    $query = Drupal::entityQuery('commerce_product_attribute_value');
    $result = $query->condition('name', $name)
      ->condition('attribute', $attribute)
      ->execute();

    // There should only ever be one value returned so we naively use the first
    // item in the array. This should generally be safe as this should only run
    // within a Drupal site install context.
    $attributeValue = NULL;
    if (count($result) > 0) {
      $attributeValue = ProductAttributeValue::load(reset($result));
    }

    return $attributeValue;
  }

}
