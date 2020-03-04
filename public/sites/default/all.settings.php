<?php

// Configuration directory.
$config_directories[CONFIG_SYNC_DIRECTORY] = '../conf/cmi';

// Hash salt.
$settings['hash_salt'] = 'bvZQQ28Qq1xxTW7uEND-XWGIKso9tClM0nzWJ8xoYM9cG0j_a_mlH8thumoZiGDkRHIpPKCHGQ';

// Database connection.
$databases['default']['default'] = [
  'driver' => 'mysql',
  'database' => getenv('DRUPAL_DB_NAME'),
  'username' => getenv('DRUPAL_DB_USER'),
  'password' => getenv('DRUPAL_DB_PASS'),
  'host' => getenv('DRUPAL_DB_HOST'),
  'port' => getenv('DRUPAL_DB_PORT'),
  'prefix' => '',
];

// Trusted Host Patterns, see https://www.drupal.org/node/2410395 for more information.
// If your site runs on multiple domains, you need to add these domains here
$settings['trusted_host_patterns'] = [
  '^' . str_replace('.', '\.', getenv('HOSTNAME')) . '$',
];

// Public files path
$settings['file_public_path'] = 'sites/default/files/public';

// Private files path
$settings['file_private_path'] = FALSE;

// Temp directory
$settings['file_temp_path'] = '/tmp';

// Disable CND by default
$config['cdn.settings'] = [
  'status' => FALSE,
];

// Stage file proxy URL from production URL.
$config['stage_file_proxy.settings']['origin'] = getenv('DRUPAL_PRODUCTION_URL');
