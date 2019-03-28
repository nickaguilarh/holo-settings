<?php

/**
 * This file is part of Holo settings,
 * a role & permission management solution for Laravel.
 * @license GNU GLPv3
 * @package Holo
 */

use Holo\AllowedSettingValue;
use Holo\EntitySetting;
use Holo\Setting;

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
    ],

    'models' => [
        'settings_model' => Setting::class,
        'entity_settings_model' => EntitySetting::class,
        'allowed_setting_values_model' => AllowedSettingValue::class
    ]
];
