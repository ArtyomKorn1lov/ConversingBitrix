<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

return [
    'controllers' => [
        'value' => [
            'defaultNamespace' => '\\Conversing\\RestControllers',
            'restIntegration' => [
                'enabled' => true,
                'scopes' => [],
            ],

        ],
        'readonly' => true,
    ],
];