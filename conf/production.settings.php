<?php

/**
 * Settings for production environment.
 */

// Don't show any error messages on the site (will still be shown in watchdog)
$config['system.logging']['error_level'] = 'hide';

// Expiration of cached pages on Varnish to 15 min
$config['system.performance']['cache']['page']['max_age'] = 900;

// Aggregate CSS files on
$config['system.performance']['css']['preprocess'] = 1;

// Aggregate JavaScript files on
$config['system.performance']['js']['preprocess'] = 1;

// Disabling stage file proxy on production, with that the module can be enabled even on production
$config['stage_file_proxy.settings']['origin'] = false;

// Environment indication.
$config['environment']['env'] = 'production';

// Trusted Host Patterns
$settings['trusted_host_patterns'] = [
  '^datasupport\.helsinki\.fi',
];

// ESB API endpoint settings
$config['esb']['url'] = 'https://esbpub1.it.helsinki.fi/mildred/createticket';
