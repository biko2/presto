<?php

namespace Drupal\presto\Plugin\Presto\DemoContent;

use Drupal\commerce_shipping\Entity\ShippingMethod;

/**
 * Creates the 'flat rate' shipment method.
 *
 * @PrestoEcommerceDemoContent(
 *     id = "create_flat_rate_shipment_method",
 *     label = @Translation("Create Flat Rate shipment method"),
 *     weight = 7
 * )
 *
 * @package Drupal\presto\Plugin\Presto\DemoContent
 */
class CreateFlatRateShippingMethod extends AbstractDemoContent {

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function createContent() {
    // Creates a dummy $10 flat rate shipping method.
    $method = ShippingMethod::create([
      'name' => t('Flat rate'),
      'plugin' => [
        'target_plugin_id' => 'flat_rate',
        'target_plugin_configuration' => [
          'rate_label' => t('Flat rate'),
          'rate_amount' => [
            'number' => 10,
            'currency_code' => 'AUD',
          ],
          'default_package_type' => 'custom_box',
        ],
      ],
    ]);

    $storeId = $this->loadStoreId();
    if ($storeId !== NULL) {
      $method->setStoreIds([$storeId]);
    }

    $method->save();

    // Set default shipment type on order type.
    /** @var \Drupal\commerce_order\Entity\OrderTypeInterface $orderType */
    $orderType = $this->getDefaultOrderType();
    $orderType->setThirdPartySetting(
      'commerce_shipping',
      'shipment_type',
      'default'
    );
    $orderType->save();
  }

  /**
   * Load the default order type.
   *
   * @return \Drupal\Core\Entity\EntityInterface|null
   *   Loaded order or NULL if one couldn't be loaded.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  private function getDefaultOrderType() {
    $storage = $this->entityTypeManager->getStorage('commerce_order_type');
    return $storage->load('default');
  }

}
