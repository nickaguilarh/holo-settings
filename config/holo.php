<?php

/**
 * This file is part of Holo settings,
 * a role & permission management solution for Laravel.
 * @license GNU GLPv3
 * @package Holo
 */

return [
    /*
     * Cache related settings.
     */
    'cache' => [
        'ttl' => 3600,
        'enabled' => true
    ],
    
    /*
     * Schema related settings.
     * */
    'schema' => [
        'settings_table' => 'settings',
        'entity_settings_table' => 'entity_settings',
        'allowed_setting_values_table' => 'allowed_setting_values'
    ]
];
