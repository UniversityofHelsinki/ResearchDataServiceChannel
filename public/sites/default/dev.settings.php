<?php

// Make local SSO urls work
$_SERVER['HTTPS'] = 'on';
$_SERVER["SERVER_PORT"] = getenv('HTTP_X_FORWARDED_PORT') ?: 443;
$settings['reverse_proxy'] = TRUE;
$settings['reverse_proxy_addresses'] = [$_SERVER['REMOTE_ADDR']];

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
$config['samlauth.authentication']['idp_entity_id'] = 'https://idp-datasupport.docker.sh/simplesaml/saml2/idp/metadata.php';
$config['samlauth.authentication']['idp_single_sign_on_service'] = 'https://idp-datasupport.docker.sh/simplesaml/saml2/idp/SSOService.php';
$config['samlauth.authentication']['idp_single_log_out_service'] = 'https://idp-datasupport.docker.sh/simplesaml/saml2/idp/SingleLogoutService.php';
$config['samlauth.authentication']['idp_x509_certificate'] = 'MIIDXTCCAkWgAwIBAgIJALmVVuDWu4NYMA0GCSqGSIb3DQEBCwUAMEUxCzAJBgNVBAYTAkFVMRMwEQYDVQQIDApTb21lLVN0YXRlMSEwHwYDVQQKDBhJbnRlcm5ldCBXaWRnaXRzIFB0eSBMdGQwHhcNMTYxMjMxMTQzNDQ3WhcNNDgwNjI1MTQzNDQ3WjBFMQswCQYDVQQGEwJBVTETMBEGA1UECAwKU29tZS1TdGF0ZTEhMB8GA1UECgwYSW50ZXJuZXQgV2lkZ2l0cyBQdHkgTHRkMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzUCFozgNb1h1M0jzNRSCjhOBnR+uVbVpaWfXYIR+AhWDdEe5ryY+CgavOg8bfLybyzFdehlYdDRgkedEB/GjG8aJw06l0qF4jDOAw0kEygWCu2mcH7XOxRt+YAH3TVHa/Hu1W3WjzkobqqqLQ8gkKWWM27fOgAZ6GieaJBN6VBSMMcPey3HWLBmc+TYJmv1dbaO2jHhKh8pfKw0W12VM8P1PIO8gv4Phu/uuJYieBWKixBEyy0lHjyixYFCR12xdh4CA47q958ZRGnnDUGFVE1QhgRacJCOZ9bd5t9mr8KLaVBYTCJo5ERE8jymab5dPqe5qKfJsCZiqWglbjUo9twIDAQABo1AwTjAdBgNVHQ4EFgQUxpuwcs/CYQOyui+r1G+3KxBNhxkwHwYDVR0jBBgwFoAUxpuwcs/CYQOyui+r1G+3KxBNhxkwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAAiWUKs/2x/viNCKi3Y6blEuCtAGhzOOZ9EjrvJ8+COH3Rag3tVBWrcBZ3/uhhPq5gy9lqw4OkvEws99/5jFsX1FJ6MKBgqfuy7yh5s1YfM0ANHYczMmYpZeAcQf2CGAaVfwTTfSlzNLsF2lW/ly7yapFzlYSJLGoVE+OHEu8g5SlNACUEfkXw+5Eghh+KzlIN7R6Q7r2ixWNFBC/jWf7NKUfJyX8qIG5md1YUeT6GBW9Bm2/1/RiO24JTaYlfLdKK9TYb8sG5B+OLab2DImG99CJ25RkAcSobWNF5zD0O6lgOo3cEdB/ksCq3hmtlC/DlLZ/D8CJ+7VuZnS1rR2naQ==';
