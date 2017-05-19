<?php

namespace Drupal\presto_theme\Plugin\Setting\presto_theme\Browsersync;

use Drupal\bootstrap\Annotation\BootstrapSetting;
use Drupal\bootstrap\Plugin\Setting\SettingBase;
use Drupal\Core\Annotation\Translation;

/**
 * The "presto_theme_browsersync_ur" theme setting.
 *
 * @ingroup plugins_setting
 *
 * @BootstrapSetting(
 *   id = "presto_theme_browsersync_url",
 *   type = "textfield",
 *   title = @Translation("Browsersync URL"),
 *   defaultValue = "http://presto.docker",
 *   groups = {
 *     "presto_theme" = "Presto Theme",
 *     "browsersync" = @Translation("BrowserSync"),
 *   },
 * )
 */
class Url extends SettingBase {}
