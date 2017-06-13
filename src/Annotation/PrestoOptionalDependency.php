<?php

namespace Drupal\presto\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a new Presto optional dependency.
 *
 * @package Drupal\presto\Annotation
 *
 * @Annotation
 */
class PrestoOptionalDependency extends Plugin {

  /**
   * Plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The weight of the plugin in relation to other plugins.
   *
   * @var int
   */
  public $weight = 0;

}
