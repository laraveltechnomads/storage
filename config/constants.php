<?php

return [
    'emptyData'         => new \stdClass(),
    'validResponse'     => [
        'success'    => true,
        'statusCode' => 200,
    ],
    'invalidResponse'   => [
        'success'    => false,
        'statusCode' => 400,
    ],
    'invalidToken'      => [
        'success'    => false,
        'statusCode' => 401,
        'message'    => 'Unauthorized User!',
    ],

    'role'         => [
        'superadmin'     => 'admin',
        'subadmin'       => 'subadmin',
        'client' => 'client',
    ],

    'is_active'         => [
        'notActive' => 0,
        'active'    => 1,
    ],

    'is_block'          => [
        'notBlock' => 0,
        'block'    => 1,
    ],
    'document_size_limit' => 1000,    
    'patient'         => [
        'couple'   => 'couple',
        'partner'  => 'partner',
        'baby' => 'baby',
        'donor' => 'donor',
        'individual' => 'individual',
        'anc' => 'anc',
        'surrogate' => 'surrogate'
    ],
    'patientType' => [
        'couple',
        'partner',
        'baby',
        'donor',
        'individual',
        'anc'
    ],
    'table_prefix' => [
        'mst',
        'reg',
        'baby',
        'donor',
        'individual',
        'anc'
    ],
    'order_id' => ''

    #local
    #'share_form_link' => 'http://localhost/github/multiply/public',

    #hostapp_live
    #'share_form_link' => ''

    #live_aws
    #'share_form_link' => ''
];