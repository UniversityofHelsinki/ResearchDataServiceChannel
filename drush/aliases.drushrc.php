<?php

/**
 * See documentation for examples.
 *
 * @link https://github.com/drush-ops/drush/blob/master/examples/example.aliases.drushrc.php
 */

$aliases['production'] = [
  'uri' => 'https://datasupport.helsinki.fi',
  'root' => '/data/rds/public',
  'remote-host' => 'datasupport.helsinki.fi',
];

$aliases['testing'] = [
  'uri' => 'https://datasupport-test.it.helsinki.fi',
  'root' => '/data/rds/public',
  'remote-host' => 'datasupport-test.it.helsinki.fi',
];
