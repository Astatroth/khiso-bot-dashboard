<?php

return [
    'users' => [
        'Super Administrator' => [
            'username' => 'super_administrator',
            'password' => env('SUPERADMIN_PASSWORD'),
            'email' => 'superadmin@localhost',
            'phone' => '+998900000000'
        ],
        'Administrator' => [
            'username' => 'administrator',
            'password' => env('ADMIN_PASSWORD'),
            'email' => 'admin@localhost',
            'phone' => '+998900000001'
        ]
    ]
];
