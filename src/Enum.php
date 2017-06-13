<?php

namespace Drupal\presto;

use InvalidArgumentException;
use ReflectionClass;

/**
 * Defines an enumeration base class.
 *
 * Based off commerceguys/enum, which we can't depend on as we need to be able
 * to run the installer without any composer dependencies.
 *
 * @package Drupal\presto
 */
abstract class Enum {

  /**
   * Static flywheel cache of available values.
   *
   * @var array
   */
  protected static $values = [];

  // @codingStandardsIgnoreStart
  /**
   * Enums can't be instantiated.
   */
  private function __construct() {
    // Do nothing.
  }
  // @codingStandardsIgnoreEnd

  /**
   * Get all constants.
   *
   * @return array
   *   Constant values, keyed by constant name.
   *
   * @throws \ReflectionException
   */
  public static function getAll() {
    $class = static::class;
    if (!array_key_exists($class, static::$values)) {
      $reflection = new ReflectionClass($class);
      static::$values[$class] = $reflection->getConstants();
    }

    return static::$values[$class];
  }

  /**
   * Checks that a particular constant is defined.
   *
   * @param string $value
   *   Constant name.
   *
   * @return bool
   *   TRUE if the value is defined, FALSE otherwise.
   *
   * @throws \ReflectionException
   */
  public static function exists($value) {
    return in_array($value, static::getAll(), TRUE);
  }

  /**
   * Asserts that a constant is defined.
   *
   * @param string $value
   *   Constant name.
   *
   * @throws \InvalidArgumentException
   *   If the value is not defined.
   *
   * @throws \ReflectionException
   */
  public static function assertExists($value) {
    if (static::exists($value) === FALSE) {
      throw new InvalidArgumentException("{$value} is not valid.");
    }
  }

}
