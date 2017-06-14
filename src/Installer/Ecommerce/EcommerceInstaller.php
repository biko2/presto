<?php

namespace Drupal\presto\Installer\Ecommerce;

use Drupal;
use Drupal\presto\Installer\DemoContentManager;
use Drupal\presto\Installer\DemoContentTypes;
use Drupal\presto\Installer\DependencyTypes;
use Drupal\presto\Installer\InstallerInterface;
use Drupal\presto\Mixins\DrupalDependencyInstallerTrait;

/**
 * Presto eCommerce module + content installer.
 *
 * @package Drupal\presto\Installer\Ecommerce
 */
class EcommerceInstaller implements InstallerInterface {

  use DrupalDependencyInstallerTrait;

  /**
   * All eCommerce dependencies.
   *
   * @var array
   */
  private $dependencies = [
    'commerce' => DependencyTypes::MODULE,
    'commerce_order' => DependencyTypes::MODULE,
    'commerce_price' => DependencyTypes::MODULE,
    'commerce_product' => DependencyTypes::MODULE,
    'commerce_cart' => DependencyTypes::MODULE,
    'commerce_checkout' => DependencyTypes::MODULE,
    'commerce_payment' => DependencyTypes::MODULE,
    'commerce_payment_example' => DependencyTypes::MODULE,
    'commerce_promotion' => DependencyTypes::MODULE,
    'commerce_tax' => DependencyTypes::MODULE,
    'commerce_log' => DependencyTypes::MODULE,
    'physical' => DependencyTypes::MODULE,
    'commerce_shipping' => DependencyTypes::MODULE,
  ];

  /**
   * Current install state.
   *
   * @var array
   */
  private $installState;

  /**
   * The demo content creation manager.
   *
   * @var \Drupal\presto\Installer\DemoContentManager
   */
  private $demoContentManager;

  /**
   * PrestoEcommerceInstaller constructor.
   *
   * @param \Drupal\presto\Installer\DemoContentManager $manager
   *   The demo content creation manager.
   * @param array $installState
   *   Current install state.
   */
  public function __construct(
    DemoContentManager $manager,
    array $installState = []
  ) {
    $this->installState = $installState;
    $this->demoContentManager = $manager;
  }

  /**
   * {@inheritdoc}
   */
  public function setInstallState(array $installState) {
    $this->installState = $installState;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function installIfEnabled() {
    $operations = [];

    // Attempt to install modules if we can.
    if ($this->shouldInstallModules()) {
      $operations = array_merge($operations, $this->addDependencyOperations());
    }

    if ($this->shouldInstallDemoContent()) {
      $operations = array_merge($operations, $this->addDemoContentOperations());
    }

    return $operations;
  }

  /**
   * Check if this installer is allowed to install eCommerce modules.
   *
   * @return bool
   *   TRUE if allowed, FALSE otherwise.
   */
  private function shouldInstallModules() {
    if (!array_key_exists('presto_ecommerce_enabled', $this->installState)) {
      return FALSE;
    }
    return (bool) $this->installState['presto_ecommerce_enabled'];
  }

  /**
   * Check if we should create demo content too.
   *
   * @return bool
   *   TRUE if allowed, FALSE otherwise.
   */
  private function shouldInstallDemoContent() {
    if (!array_key_exists('presto_ecommerce_install_demo_content', $this->installState)) {
      return FALSE;
    }
    $create = (bool) $this->installState['presto_ecommerce_install_demo_content'];
    return $this->shouldInstallModules() && $create;
  }

  /**
   * Crates a set of batch operations to install all required dependencies.
   *
   * @return array
   *   A set of Drupal batch operations.
   */
  private function addDependencyOperations() {
    $operations = [];

    foreach ($this->dependencies as $module => $type) {
      $operations[] = [
        [static::class, 'installDependency'],
        [
          $module,
          $type,
        ],
      ];
    }

    return $operations;
  }

  /**
   * Crates a set of batch operations to create demo content.
   *
   * @return array
   *   A set of Drupal batch operations.
   */
  private function addDemoContentOperations() {
    $operations = [];

    $contentDefs = $this->demoContentManager->getFilteredDefinitions(
      DemoContentTypes::ECOMMERCE
    );

    // Add module install task to install our commerce exports module.
    $operations[] = [
      [static::class, 'installDependency'],
      [
        'presto_commerce',
        DependencyTypes::MODULE,
      ],
    ];

    // Run any further content tasks.
    foreach ($contentDefs as $def) {
      $operations[] = [
        [static::class, 'createDemoContent'],
        [$def['id']],
      ];
    }

    return $operations;
  }

  /**
   * Creates a demo content item.
   *
   * This is a Drupal batch callback operation and as such, needs to be both a
   * public and a static function so that the Batch API can access it outside
   * the context of this class.
   *
   * @param string $pluginId
   *   Demo content class plugin ID.
   * @param array $context
   *   Batch context.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public static function createDemoContent($pluginId, array &$context) {
    // Reset time limit so we don't timeout.
    drupal_set_time_limit(0);

    // Needs to be resolved manually since we don't have a context.
    /** @var \Drupal\presto\Installer\DemoContentManager $demoContentManager */
    $demoContentManager = Drupal::service(
      'plugin.manager.presto.demo_content'
    );

    $definition = $demoContentManager->getDefinition($pluginId);
    /** @var \Drupal\Core\StringTranslation\TranslatableMarkup $label */
    $label = $definition['label'];

    /** @var \Drupal\presto\Plugin\Presto\DemoContent\AbstractDemoContent $instance */
    $instance = $demoContentManager->createInstance($pluginId);
    $instance->createContent();

    $context['results'][] = $pluginId;
    $context['message'] = t('Running %task_name', [
      '%task_name' => lcfirst($label->render()),
    ]);
  }

}
