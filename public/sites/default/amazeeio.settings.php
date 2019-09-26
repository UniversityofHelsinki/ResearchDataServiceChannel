<?php

$databases['default']['default'] = array(
  'driver' => 'mysql',
  'database' => getenv('AMAZEEIO_SITENAME'),
  'username' => getenv('AMAZEEIO_DB_USERNAME'),
  'password' => getenv('AMAZEEIO_DB_PASSWORD'),
  'host' => getenv('AMAZEEIO_DB_HOST'),
  'port' => getenv('AMAZEEIO_DB_PORT'),
  'prefix' => '',
);

// Base URL
if (getenv('AMAZEEIO_BASE_URL')) {
  $base_url = getenv('AMAZEEIO_BASE_URL');
}

// Trusted Host Patterns, see https://www.drupal.org/node/2410395 for more information.
// If your site runs on multiple domains, you need to add these domains here
$settings['trusted_host_patterns'] = array(
  '^' . str_replace('.', '\.', getenv('AMAZEEIO_SITE_URL')) . '$',
);

// Temp directory
if (getenv('AMAZEEIO_TMP_PATH')) {
  $config['system.file']['path']['temporary'] = getenv('AMAZEEIO_TMP_PATH');
}

// Hash salt
if (getenv('AMAZEEIO_HASH_SALT')) {
  $settings['hash_salt'] = getenv('AMAZEEIO_HASH_SALT');
}

// Varnish & Reverse proxy settings
if (getenv('AMAZEEIO_VARNISH_HOSTS') && getenv('AMAZEEIO_VARNISH_SECRET')) {
  $varnish_hosts = explode(',', getenv('AMAZEEIO_VARNISH_HOSTS'));
  array_walk($varnish_hosts, function(&$value, $key) { $value .= ':6082'; });

  $settings['reverse_proxy'] = TRUE;
  $settings['reverse_proxy_addresses'] = array_merge(explode(',', getenv('AMAZEEIO_VARNISH_HOSTS')), array('127.0.0.1'));

  $config['varnish.settings']['varnish_control_terminal'] = implode($varnish_hosts, " ");
  $config['varnish.settings']['varnish_control_key'] = getenv('AMAZEEIO_VARNISH_SECRET');
  $config['varnish.settings']['varnish_version'] = 4;
}
