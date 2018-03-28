<?php

/**
 * See documentation for examples.
 *
 * @link https://github.com/drush-ops/drush/blob/master/examples/example.aliases.drushrc.php
 */

/**
 * Placeholder aliases. Remove the leading hash signs to enable.
 *
 * These are the environment names we have decided to use, please don't change
 * them.
 */
$aliases['production'] = array(
  'uri' => 'https://datasupport.helsinki.fi',
  'root' => '/data/rds/public',
  'remote-host' => 'datasupport.helsinki.fi',
  'remote-user' => 'USERNAME',
);

#$aliases['staging'] = array(
#  'uri' => 'http://staging.example.com',
#  'root' => '/var/www/example.com/current',
#  'remote-host' => 'staging.example.com',
#  'remote-user' => 'root',
#);

#$aliases['testing'] = array(
#  'uri' => 'https://dev.researchdata-hy.com/',
#  'root' => '/var/www/dev.researchdata-hy.com/public',
#  'remote-host' => 'dev.researchdata-hy.com',
#  'remote-user' => 'centos',
#);
