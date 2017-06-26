<?php

namespace Drupal\presto\Plugin\Presto\OptionalDependency;

use Drupal\Core\Form\FormStateInterface;
use Drupal\presto\Mixins\DrupalConfigReaderTrait;

/**
 * Installs Presto Theme Commerce Blocks if possible.
 *
 * @PrestoOptionalDependency(
 *     id = "install_presto_theme_commerce_blocks",
 *     label = @Translation("Install Presto Theme Commerce Blocks"),
 *     weight = 1
 * )
 */
class InstallPrestoThemeCommerceBlocks extends AbstractOptionalDependency {

  use DrupalConfigReaderTrait;

  const THEME_NAME = 'presto_theme';
  const MODULE_NAME = 'presto_commerce';

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      static::THEME_NAME => '',
      static::MODULE_NAME => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function shouldInstall(array $installState) {
    return ($this->configuration[static::THEME_NAME] === 1) &&
      ($this->configuration[static::MODULE_NAME] === 1);
  }

  /**
   * Get any required Batch API install operations for this dependency.
   *
   * @return array
   *   Batch operation definitions.
   */
  public function getInstallOperations() {
    return [
      [
        [static::class, 'readBlockConfig'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(
    array $form,
    FormStateInterface $form_state
  ) {
    // No configuration required for this dependency.
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(
    array &$form,
    FormStateInterface $form_state
  ) {
    // Nothing to do, we don't have a form.
  }

  /**
   * Read config.
   *
   * @throws \Drupal\Core\Config\UnsupportedDataTypeConfigException
   * @throws \Drupal\Core\Config\StorageException
   */
  public static function readBlockConfig() {
    $themePath = drupal_get_path('module', 'presto_theme');
    $configPath = "{$themePath}/config/optional";
    static::readConfig(
      $configPath,
      'block.block.views_block__presto_product_listing_listing_block.yml'
    );
  }

}
