<?php

$config = [
    'admin' => [
        'core:AdminPassword',
    ],
    'example-userpass' => [
        'exampleauth:UserPass',
        'teppo:tutkija' => [
            'urn:oid:2.5.4.42' => ['Teppo'],
            'urn:oid:2.5.4.4' => ['Tutkija'],
            'urn:oid:0.9.2342.19200300.100.1.3' => ['teppo.tutkija@helsinki.fi'],
            'urn:mace:funet.fi:helsinki.fi:hyGroupCn' => ['tutkijat'],
        ],
    ],
];
