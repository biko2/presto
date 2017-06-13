<?php

namespace Drupal\presto\Mixins;

/**
 * Adds definition sorting (by weight) to plugin managers.
 *
 * @package Drupal\presto\Mixins
 */
trait WeightedPluginManagerTrait {

  /**
   * Sorts plugins by weight.
   *
   * @param array $definitions
   *   List of plugin definitions, each MUST have a 'weight' key.
   *
   * @return array
   *   Sorted definitions.
   */
  protected function sortByWeight(array $definitions) {
    // Sort definitions by weight before returning.
    uasort($definitions, function ($first, $second) {
      if ($first['weight'] === $second['weight']) {
        return 0;
      }
      return ($first['weight'] < $second['weight']) ? -1 : 1;
    });

    return $definitions;
  }

}
