<?php

namespace Drupal\presto\Installer\Ecommerce\Content\Plugin;

/**
 * Creates the demo Drupal Commerce store.
 *
 * @PrestoEcommerceDemoContent(
 *     id = "create_ebook_product",
 *     label = @Translation("Create eBook product"),
 *     weight = 6
 * )
 *
 * @package Drupal\presto\Installer\Ecommerce\Content\Plugin
 */
class CreateEbookProduct extends AbstractBaseProductCreator {

  /**
   * {@inheritdoc}
   */
  protected function productDetails() {
    return [
      'type' => 'ebook',
      'title' => t('Demo eBook'),
      'description' => t('<p>
Praesent condimentum tristique nisi a adipiscing vestibulum eu himenaeos pharetra parturient tincidunt mattis pulvinar a laoreet. Vulputate per suspendisse risus at vel adipiscing senectus phasellus aliquam sem a nullam dictumst vitae scelerisque bibendum condimentum. Ullamcorper orci elit a sodales mi a suspendisse malesuada suspendisse rhoncus ridiculus odio ullamcorper montes laoreet enim a malesuada adipiscing consectetur scelerisque in a nibh nibh laoreet urna venenatis. A a nam velit ullamcorper per a suspendisse sem ornare nunc parturient a rhoncus sem libero risus ante a vitae dictumst rhoncus suscipit suspendisse erat id feugiat dapibus. Justo ridiculus proin rhoncus mi senectus sodales ridiculus consequat parturient ultricies scelerisque mus blandit augue nec ullamcorper vestibulum porttitor nam scelerisque fusce fringilla condimentum erat hac per sodales a.</p>'),
      'path' => [
        'alias' => '/products/ebook',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function productVariations() {
    return [
      [
        'type' => 'ebook',
        'sku' => 'EBK-1',
        'price' => [
          'number' => 6.95,
          'currency_code' => 'AUD',
        ],
        'attribute_ebook_format' => $this->loadAttributeValue(
          'ePub',
          'ebook_format'
        ),
        'status' => 1,
      ],
      [
        'type' => 'ebook',
        'sku' => 'EBK-2',
        'price' => [
          'number' => 7.98,
          'currency_code' => 'AUD',
        ],
        'attribute_ebook_format' => $this->loadAttributeValue(
          'Mobi',
          'ebook_format'
        ),
        'status' => 1,
      ],
    ];
  }

}
