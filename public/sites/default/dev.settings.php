<?php

// Skip file system permissions hardening.
$settings['skip_permissions_hardening'] = TRUE;

// Public files path
$settings['file_public_path'] = 'sites/default/files';

$settings['reverse_proxy'] = FALSE;

// Show all error messages on the site.
$config['system.logging']['error_level'] = 'all';

// Expiration of cached pages to 0.
$config['system.performance']['cache']['page']['max_age'] = 0;

// Aggregate CSS files off.
$config['system.performance']['css']['preprocess'] = 0;

// Aggregate JavaScript files off.
$config['system.performance']['js']['preprocess'] = 0;

// Disable Google Analytics from sending dev GA data.
$config['google_analytics.settings']['account'] = 'UA-XXXXXXXX-YY';

// ESB API endpoint settings
$config['esb']['url'] = 'https://dragon.it.helsinki.fi/devel/mildred/createticket';

// Stage file proxy URL from production URL.
$config['stage_file_proxy.settings']['origin'] = 'https://datasupport.helsinki.fi';

// SAML settings

// SP Entity ID for development & testing
$config['samlauth.authentication']['sp_entity_id'] = 'https://datasupport.docker.sh';
$config['samlauth.authentication']['sp_cert_folder'] = '/app/conf/samlauth';
$config['samlauth.authentication']['idp_entity_id'] = 'https://login-test.it.helsinki.fi/shibboleth';
$config['samlauth.authentication']['idp_single_sign_on_service'] = 'https://idp-datasupport.docker.sh/simplesaml/saml2/idp/SSOService.php';
$config['samlauth.authentication']['idp_single_log_out_service'] = 'https://idp-datasupport.docker.sh/simplesaml/saml2/idp/SingleLogoutService.php';
$config['samlauth.authentication']['idp_change_password_service'] = 'https://www.helsinki.fi/salasana';
