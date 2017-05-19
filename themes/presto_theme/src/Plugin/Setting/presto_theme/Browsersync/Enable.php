<?php

namespace Drupal\presto_theme\Plugin\Setting\presto_theme\Browsersync;

use Drupal\bootstrap\Annotation\BootstrapSetting;
use Drupal\bootstrap\Plugin\Setting\SettingBase;
use Drupal\Core\Annotation\Translation;

/**
 * The "presto_theme_browsersync_enable" theme setting.
 *
 * @ingroup plugins_setting
 *
 * @BootstrapSetting(
 *   id = "presto_theme_browsersync_enable",
 *   type = "checkbox",
 *   title = @Translation("Enable Browsersync"),
 *   defaultValue = false,
 *   groups = {
 *     "presto_theme" = "Presto Theme",
 *     "browsersync" = @Translation("BrowserSync"),
 *   },
 * )
 */
class Enable extends SettingBase {}
