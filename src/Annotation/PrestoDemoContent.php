<?php

namespace Drupal\presto\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a new 'Demo Content' annotation type.
 *
 * @package Drupal\presto\Annotation
 *
 * @Annotation
 */
class PrestoDemoContent extends Plugin {

  /**
   * Plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * Plugin type (e.g. 'ecommerce').
   *
   * @var string
   */
  public $type;

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
  public $weight;

}
