<?php

namespace Drupal\presto\Plugin\Presto\OptionalDependency;

use Drupal\Core\Form\FormStateInterface;
use Drupal\presto\Installer\DependencyTypes;

/**
 * Installs swiftmailer if possible.
 *
 * @PrestoOptionalDependency(
 *     id = "install_swiftmailer",
 *     label = @Translation("Install SwiftMailer"),
 *     weight = 0
 * )
 */
class InstallSwiftmailer extends AbstractOptionalDependency {

  // The swiftmailer module machine name.
  const MODULE_NAME = 'swiftmailer';

  /**
   * {@inheritdoc}
   */
  public function shouldInstall(array $installState) {
    // Only install this if the swiftmailer library exist. It may not if this
    // profile was downloaded from drupal.org.
    /** @noinspection ClassConstantCanBeUsedInspection */
    return class_exists('\Swift_Mailer');
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
        [static::class, 'installDependency'],
        [
          static::MODULE_NAME,
          DependencyTypes::MODULE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    // This dependency has no configuration.
    return [];
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

}
