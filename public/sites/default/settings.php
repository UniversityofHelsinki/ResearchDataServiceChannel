<?php

// Check ENV and load relevant configuration.
require_once 'drupal.configurator.php';

/**
 * Only in Wodby environment.
 */

if (isset($_SERVER['WODBY_APP_NAME'])) {
  // The include won't be added automatically if it's already there.
  include '/var/www/conf/wodby.settings.php';

  // Override setting from wodby.settings.php.
  $config_directories[CONFIG_SYNC_DIRECTORY] = '../conf/cmi';
}
