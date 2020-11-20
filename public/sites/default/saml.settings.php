<?php

// SP conf
$config['samlauth.authentication']['sp_name_id_format'] = 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient';
$config['samlauth.authentication']['sp_cert_type'] = 'folder';
$config['samlauth.authentication']['sp_cert_folder'] = '/data/rds/shared';
$config['samlauth.authentication']['sp_x509_certificate'] = '';
$config['samlauth.authentication']['sp_private_key'] = '';

// IdP certificate
// Info: https://wiki.helsinki.fi/display/IAMasioita/IdP+sertifikaatin+vaihto
// PEM: https://login.helsinki.fi/metadata/login.helsinki.fi-signing.pem
$config['samlauth.authentication']['idp_x509_certificate'] = 'MIIFCzCCAvOgAwIBAgIJAPtmOYNbClWkMA0GCSqGSIb3DQEBCwUAMBwxGjAYBgNV BAMMEWxvZ2luLmhlbHNpbmtpLmZpMB4XDTE4MDUxODA4NDk1M1oXDTM4MDUxODA4 NDk1M1owHDEaMBgGA1UEAwwRbG9naW4uaGVsc2lua2kuZmkwggIiMA0GCSqGSIb3 DQEBAQUAA4ICDwAwggIKAoICAQDhxj8XiSWRbzRUcPoCjdotkJnvtNK7OGG72k4F Lxm0VCNvv6kYKY58lamOCPT/er64IxN3MUzmAIguuQPidVCk7ZYodb0+STOwy8fq TDJTH4H47dvoyK2O1li/74Fh/UVCfKzeVAv0nGPErAmOHULrROFiUxmeFE+7RO1I G1NGAXei1uAIuzNPrv/8pqhJw8MucMZAIX3ngZjGk0gaSs6HB8bZfQZo9UTYN7wa HuENjan+OzDYwf1fim6VfDmMatWZsnCWb3qDJt7rF2G+YfgVE6QwFA/9z4xERtbw 4Ub1vdFLsu9i3zVv4Qxx/UxvvANNK4tloeiEMHPD/6/Ww90HZ1lUQ3qNERyv20lI HT2BiJSpOvF6UJSH8FESKLOMuBRzQicwgXtUNUAg3yw7IirQZVsv71MxiBgcCZOB hUqX+JG/MlUWrac0cj0WmACvhrUBRjKUkHXNLws3lOW1d646TWbtIaSRNNF/irLn scHsADdOnDT/E9V7UCzGJdJZtbjv2KjeNgoNM5uUYxg+cFqbv+5japKKoTOPHLYA 3Fcf4PyiTiJSCLCgHLXYmsTRxUWAku4P7OJMK7xZweWySlP+tXFrXIVP7XGLj/Xg 5xVxoU8PwrSAyT0VZigaCDSG5B0+mXjrv2LZwyPAL/EXXycICnWUz2wf5HwbV9/w e0HTjQIDAQABo1AwTjAdBgNVHQ4EFgQUC5QR1gXp3ltxIZr0SwKg4X5SpTIwHwYD VR0jBBgwFoAUC5QR1gXp3ltxIZr0SwKg4X5SpTIwDAYDVR0TBAUwAwEB/zANBgkq hkiG9w0BAQsFAAOCAgEACCtoT/M+YT8uExP6kTqkww6IwMEtW/X3mT2sJQv5I3vD ivHXwYEoVfvwDe8B/H48RE4Bh93vHqPPQ0iXEUPtldM4dcOMd7711AVxpKe62iF7 Uy3YtQ+5Jxk6mexfnjMek5L5jz0eLkHTqw9v6K22VQHAx8GQ7SPSfpt+Qow3JIXS z+nzPURR14STo4CnC6a/DO1r4yXMThIf+wfQwTyRQBFPFzDBROmYa9wMJxegcDHv ps5QUIoAdOefO++2SVnfKebkwS3UbXhCvnLt3Onfl8Juuppja/6v4ReKmX8/SHJM dEpPcnqU+fFcApqqmtTgDfxguCKrP4QLA899RaXn2KKz57jyrtMWzTIw/R3fnbeY ad7O2piQDFkWGpL87kX+rw2rcR2gARkiE3QPbNWte7aUI7nbJ1bmrCajIxqZAmK7 xJ3tuUgriaxE5e8R3gC1kjwe6Q+gTusZSFp522fc+3IXS7473LCiYUNTYAqMLIEZ NDBsIG86FEHtr+JmSUetlnH8P6IpRJSjhSCGR+kaWaTGlXaUbqNzsACi9vZpKDz3 9+0c121p2IFuZk7RHlAjPjVJZa/b/0Etv5pFoduHR+iT4QmB/8EJ5x8VrKqokIkE /nVED8wlU5toDn0zH3AateXZreGNyTuXmIU3RlZr0iVtcnu+QcsTfd4CEV2gubE=';

// Drupal
$config['samlauth.authentication']['drupal_saml_login'] = FALSE;
$config['samlauth.authentication']['create_users'] = FALSE;
$config['samlauth.authentication']['map_users'] = FALSE;

// Attributes
$config['samlauth.authentication']['map_users_email'] = '';
$config['samlauth.authentication']['unique_id_attribute'] = 'urn:oid:0.9.2342.19200300.100.1.1';
$config['samlauth.authentication']['user_name_attribute'] = 'urn:oid:2.5.4.3';
$config['samlauth.authentication']['user_mail_attribute'] = 'urn:oid:0.9.2342.19200300.100.1.3';
$config['samlauth.authentication']['user_group_attribute'] = 'urn:mace:funet.fi:helsinki.fi:hyGroupCn';
$config['samlauth.authentication']['user_username_attribute'] = 'urn:oid:0.9.2342.19200300.100.1.1';

// Security
$config['samlauth.authentication']['security_authn_requests_sign'] = TRUE;
$config['samlauth.authentication']['security_messages_sign'] = TRUE;
$config['samlauth.authentication']['security_name_id_sign'] = FALSE;
$config['samlauth.authentication']['security_request_authn_context'] = FALSE;
