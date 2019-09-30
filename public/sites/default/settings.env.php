<?php

/**
 * Settings for local development environment.
 */

$settings['reverse_proxy'] = FALSE;

// Show all error messages on the site
$config['system.logging']['error_level'] = 'all';

// Expiration of cached pages to 0
$config['system.performance']['cache']['page']['max_age'] = 0;

// Aggregate CSS files off
$config['system.performance']['css']['preprocess'] = 0;

// Aggregate JavaScript files off
$config['system.performance']['js']['preprocess'] = 0;

// Disable Google Analytics from sending dev GA data.
$config['google_analytics.settings']['account'] = 'UA-XXXXXXXX-YY';

// Stage file proxy URL from production URL
if (getenv('AMAZEEIO_PRODUCTION_URL')){
  $config['stage_file_proxy.settings']['origin'] = getenv('AMAZEEIO_PRODUCTION_URL');
}

// ESB API endpoint settings
$config['esb']['url'] = 'https://dragon.it.helsinki.fi/devel/mildred/createticket';
