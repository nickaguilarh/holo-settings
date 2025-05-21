<?php


namespace Holo\Relationships;


use Holo\Models\AllowedSettingValue;
use Holo\Models\EntitySetting;

trait SettingRelationships
{
    /**
     * Retrieves all the entity with settings that this setting is associated.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entitySettings()
    {
        return $this->hasMany(config('holo.entity_settings_model', EntitySetting::class));
    }

    /**
     * Retrieves all the allowed values for this setting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allowedValues()
    {
        return $this->hasMany(config('holo.allowed_setting_values_model', AllowedSettingValue::class));
    }
}
