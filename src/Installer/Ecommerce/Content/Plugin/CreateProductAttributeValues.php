<?php

namespace Drupal\presto\Installer\Ecommerce\Content\Plugin;

use Drupal\commerce_product\Entity\ProductAttributeValue;

/**
 * Creates a set of demo product attribute values.
 *
 * @PrestoEcommerceDemoContent(
 *     id = "product_attribute_values",
 *     label = @Translation("Create Drupal Commerce product attribute values"),
 *     weight = 2
 * )
 *
 * @package Drupal\presto\Installer\Ecommerce\Content\Plugin
 */
class CreateProductAttributeValues extends AbstractDemoContent {

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function createContent() {
    foreach ($this->getAttributeValues() as $attributeId => $values) {
      foreach ($values as $value) {
        $attributeValue = ProductAttributeValue::create([
          'attribute' => $attributeId,
          'name' => $value,
        ]);
        $attributeValue->save();
      }
    }
  }

  /**
   * Attribute value definitions.
   *
   * @return array[]
   *   Definitions.
   */
  private function getAttributeValues() {
    return [
      'book_binding' => [
        t('Paperback'),
        t('Hardcover'),
      ],
      'ebook_format' => [
        t('ePub'),
        t('Mobi'),
        t('PDF'),
        t('HTML'),
      ],
    ];
  }

}
