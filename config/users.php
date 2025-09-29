<?php

return [
    'roles' => [
        'admin' => [
            'label' => 'Administrador',
            'permissions' => ['*'],
        ],
    ],

    'defaults' => [
        'role' => 'admin',
    ],
];
