<?php

return [
    'commands' => [
        'update' => [
            'signature' => 'app:update',
            'description' => 'Runs update scripts.'
        ],
        'storage' => [
            'signature' => 'storage:link',
            'description' => 'Create the symbolic links configured for the application.'
        ],
        'migrate' => [
            'signature' => 'migrate',
            'description' => 'Executes migrate command.'
        ]
    ]
];
