<?php

namespace Drupal\presto\Plugin\Presto\OptionalDependency;

use Drupal;
use Drupal\Core\Form\FormStateInterface;


/**
 * Installs presto theme if selected..
 *
 * @PrestoOptionalDependency(
 *     id = "install_prestotheme",
 *     label = @Translation("Install Presto Theme"),
 *     weight = 0
 * )
 */
class InstallPrestoTheme extends AbstractOptionalDependency{

  /**
   * Gets default configuration for this plugin.
   *
   * @return array
   *   An associative array with the default configuration.
   */
  public function defaultConfiguration()
  {
    return [
      'presto_theme' => '',
    ];
  }

  /**
   * Checks if this dependency should be installed.
   *
   * @param array $installState
   *   The current Drupal install state.
   *
   * @return bool
   *   TRUE if this dependency should be installed, FALSE otherwise.
   */
  public function shouldInstall(array $installState)
  {
  }

  /**
   * Get any required Batch API install operations for this dependency.
   *
   * @return array
   *   Batch operation definitions.
   */
  public function getInstallOperations()
  {
  }

  /**
   * Form constructor.
   *
   * Plugin forms are embedded in other forms. In order to know where the plugin
   * form is located in the parent form, #parents and #array_parents must be
   * known, but these are not available during the initial build phase. In order
   * to have these properties available when building the plugin form's
   * elements, let this method return a form element that has a #process
   * callback and build the rest of the form in the callback. By the time the
   * callback is executed, the element's #parents and #array_parents properties
   * will have been set by the form API. For more documentation on #parents and
   * #array_parents, see \Drupal\Core\Render\Element\FormElement.
   *
   * @param array $form
   *   An associative array containing the initial structure of the plugin form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form. Calling code should pass on a subform
   *   state created through
   *   \Drupal\Core\Form\SubformState::createForSubform().
   *
   * @return array
   *   The form structure.
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $form['presto_theme'] = [
      '#type' => 'checkbox',
      '#title' => t('Install Presto Theme'),
      '#description' =>t(
        'Install and set as default the Presto Theme.'
      ),
      '#attributes' => ['checked' => 'checked'],
    ];

    return $form;
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the plugin form as built
   *   by static::buildConfigurationForm().
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form. Calling code should pass on a subform
   *   state created through
   *   \Drupal\Core\Form\SubformState::createForSubform().
   * @throws \Drupal\Core\Config\ConfigValueException
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state)
  {
    // Set Presto Theme as default.
    if($form_state->getValue('presto_theme') === 1)
    {
      // Enable presto_theme.
      Drupal::service('theme_installer')
        ->install(['presto_theme']);

      // Set presto_theme as default.
      Drupal::configFactory()
        ->getEditable('system.theme')
        ->set('default', 'presto_theme')
        ->save();

      // Positioning the blocks if needed.
    }
  }
}
