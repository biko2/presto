<?php
/*
 * @file
 * Based on code by Acquia in acquia/lightning, copyright (c) 2017.
 * Distributed under the GNU GPL v2 or higher. For full terms see the LICENSE
 * file.
 */

namespace Sitback\Presto\Composer;

// use Acquia\Lightning\IniEncoder;
use Composer\Package\PackageInterface;
use Composer\Script\Event;
use Composer\Util\ProcessExecutor;
use Symfony\Component\Yaml\Yaml;

/**
 * Generates Drush make files, heavily inspired by acquia/lightning.
 */
class Package {

  /**
   * Main entry point for command.
   *
   * @param \Composer\Script\Event $event
   */
  public static function execute(Event $event) {
    $composer = $event->getComposer();
  }

}
