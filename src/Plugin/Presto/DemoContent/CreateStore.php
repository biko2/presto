<?php

namespace Drupal\presto\Plugin\Presto\DemoContent;

use Drupal;
use Drupal\commerce_store\Entity\Store;

/**
 * Creates the demo Drupal Commerce store.
 *
 * @PrestoEcommerceDemoContent(
 *     id = "store",
 *     label = @Translation("Create Drupal Commerce demo store"),
 *     weight = 1
 * )
 *
 * @package Drupal\presto\Plugin\Presto\DemoContent
 */
class CreateStore extends AbstractDemoContent {

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Drupal\Core\Config\ConfigValueException
   */
  public function createContent() {
    $store = Store::create([
      'type' => 'online',
      'name' => t('Presto Bookshop'),
      'mail' => 'presto@sitback.com.au',
      'address' => [
        'address_line1' => '39-41 Lower Fort Street',
        'locality' => 'The Rocks',
        'postal_code' => '2000',
        'administrative_area' => 'NSW',
        'country_code' => 'AU',
      ],
      'tax_registrations' => [
        'AU',
      ],
      'default_currency' => [
        'AUD',
      ],
    ]);
    $store->save();

    // Set this as the default store.
    $storeId = $store->uuid();
    /** @var \Drupal\Core\Config\Config $config */
    $config = Drupal::service('config.factory')
      ->getEditable('commerce_store.settings');
    $config->set('default_store', $storeId);
    $config->save();
  }

}
