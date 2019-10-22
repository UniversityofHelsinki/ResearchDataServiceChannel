<?php

// Drupal Configurator. Detects the Cloud and converts ENV vars to generalized ones.

/**
 * Amazee.io Legacy. @see https://docs.amazee.io/environment_variables.html
 */

if (getenv('AMAZEEIO_SITENAME')) {
  if (getenv('AMAZEEIO_SITE_ENVIRONMENT') === 'development') {
    putenv('APP_ENV=dev');
  }
  else if (getenv('AMAZEEIO_SITE_ENVIRONMENT') === 'production') {
    putenv('APP_ENV=prod');
  }

  putenv('DRUPAL_DB_NAME='. getenv('AMAZEEIO_SITENAME'));
  putenv('DRUPAL_DB_USER='. getenv('AMAZEEIO_DB_USERNAME'));
  putenv('DRUPAL_DB_PASS='. getenv('AMAZEEIO_DB_PASSWORD'));
  putenv('DRUPAL_DB_HOST='. getenv('AMAZEEIO_DB_HOST'));
  putenv('DRUPAL_DB_PORT='. getenv('AMAZEEIO_DB_PORT'));
}

/**
 * Lagoon.
 */

if (getenv('LAGOON')) {
  if (getenv('LAGOON_ENVIRONMENT_TYPE') === 'development') {
    putenv('APP_ENV=dev');
  }
  else if (getenv('LAGOON_ENVIRONMENT_TYPE') === 'production') {
    putenv('APP_ENV=prod');
  }

  putenv('DRUPAL_DB_NAME='. getenv('MARIADB_DATABASE') ?: 'drupal');
  putenv('DRUPAL_DB_USER='. getenv('MARIADB_USERNAME') ?: 'drupal');
  putenv('DRUPAL_DB_PASS='. getenv('MARIADB_PASSWORD') ?: 'drupal');
  putenv('DRUPAL_DB_HOST='. getenv('MARIADB_HOST') ?: 'mariadb');
  putenv('DRUPAL_DB_PORT=3306');
}

/**
 * Lando.
 */

if (getenv('LANDO_INFO')) {
  $info = json_decode(getenv('LANDO_INFO'), TRUE);
  print_r($info);
}

/**
 * Wodby. @see https://wodby.com/docs/infrastructure/env-vars/
 */

if (getenv('WODBY_INSTANCE_TYPE')) {
  putenv('APP_ENV='. getenv('WODBY_INSTANCE_TYPE'));

  putenv('HOSTNAME='. getenv('WODBY_HOST_PRIMARY'));

  putenv('DRUPAL_DB_NAME='. getenv('DB_NAME'));
  putenv('DRUPAL_DB_USER='. getenv('DB_USER'));
  putenv('DRUPAL_DB_PASS='. getenv('DB_PASSWORD'));
  putenv('DRUPAL_DB_HOST='. getenv('DB_HOST'));
  putenv('DRUPAL_DB_PORT='. getenv('MARIADB_SERVICE_PORT'));
}

/**
 * Some servers don't allow setting HOSTNAME globally, use then DRUPAL_HOSTNAME.
 */

if (getenv('DRUPAL_HOSTNAME')) {
  putenv('HOSTNAME='. getenv('DRUPAL_HOSTNAME'));
}

/**
 * ENV. By default it's least open, so prod.
 */

$APP_ENV = getenv('APP_ENV') ?: 'prod';

/**
 * Load/add files (if exist) in following order:
 */

foreach (['all', $APP_ENV, 'local'] as $set) {
  // all.settings.php, dev.settings.php and local.settings.php
  if (file_exists(__DIR__ . '/' . $set . '.settings.php')) {
    include __DIR__ . '/' . $set . '.settings.php';
  }

  // all.services.yml, dev.services.yml and local.services.yml
  if (file_exists(__DIR__ . '/' . $set . '.services.yml')) {
    $settings['container_yamls'][] = __DIR__ . '/' . $set . '.services.yml';
  }
}
