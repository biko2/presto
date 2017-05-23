<?php

namespace Drupal\presto\Installer\Ecommerce\Content\Plugin;

/**
 * Creates the demo Drupal Commerce store.
 *
 * @PrestoEcommerceDemoContent(
 *     id = "create_physical_book_product",
 *     label = @Translation("Create physical book product"),
 *     weight = 5
 * )
 *
 * @package Drupal\presto\Installer\Ecommerce\Content\Plugin
 */
class CreatePhysicalBookProduct extends AbstractBaseProductCreator {

  /**
   * {@inheritdoc}
   */
  protected function productDetails() {
    return [
      'type' => 'book',
      'title' => t('Demo Physical Book'),
      'description' => t('<p>
Praesent condimentum tristique nisi a adipiscing vestibulum eu himenaeos pharetra parturient tincidunt mattis pulvinar a laoreet. Vulputate per suspendisse risus at vel adipiscing senectus phasellus aliquam sem a nullam dictumst vitae scelerisque bibendum condimentum. Ullamcorper orci elit a sodales mi a suspendisse malesuada suspendisse rhoncus ridiculus odio ullamcorper montes laoreet enim a malesuada adipiscing consectetur scelerisque in a nibh nibh laoreet urna venenatis. A a nam velit ullamcorper per a suspendisse sem ornare nunc parturient a rhoncus sem libero risus ante a vitae dictumst rhoncus suscipit suspendisse erat id feugiat dapibus. Justo ridiculus proin rhoncus mi senectus sodales ridiculus consequat parturient ultricies scelerisque mus blandit augue nec ullamcorper vestibulum porttitor nam scelerisque fusce fringilla condimentum erat hac per sodales a. 
</p>'),
      'path' => [
        'alias' => '/products/physical-book',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function productVariations() {
    return [
      [
        'type' => 'physical_book',
        'sku' => 'PHYSBK-1',
        'price' => [
          'number' => 10,
          'currency_code' => 'AUD',
        ],
        'attribute_book_binding' => $this->loadAttributeValue(
          'Paperback',
          'book_binding'
        ),
        'dimensions' => [
          'length' => 20,
          'width' => 10,
          'height' => 2,
          'unit' => 'cm',
        ],
        'weight' => [
          'number' => 300,
          'unit' => 'g',
        ],
        'status' => 1,
      ],
      [
        'type' => 'physical_book',
        'sku' => 'PHYSBK-2',
        'price' => [
          'number' => 15,
          'currency_code' => 'AUD',
        ],
        'attribute_book_binding' => $this->loadAttributeValue(
          'Hardcover',
          'book_binding'
        ),
        'dimensions' => [
          'length' => 25,
          'width' => 15,
          'height' => 3,
          'unit' => 'cm',
        ],
        'weight' => [
          'number' => 600,
          'unit' => 'g',
        ],
        'status' => 1,
      ],
    ];
  }

}
