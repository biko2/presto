<?php

namespace Drupal\presto\Installer;

use Drupal\presto\Enum;

/**
 * Defines dependency types.
 *
 * @package Drupal\presto\Installer
 */
final class DependencyTypes extends Enum {

  const THEME = 'theme';

  const MODULE = 'module';

}
