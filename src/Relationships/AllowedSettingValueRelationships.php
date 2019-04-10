<?php


namespace Holo\Relationships;


use Holo\EntitySetting;
use Holo\Setting;

trait AllowedSettingValueRelationships
{
    /**
     * Retrieves the setting for this allowed value.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting()
    {
        return $this->belongsTo(config('holo.settings_model', Setting::class));
    }

    /**
     * Retrieve the entities with settings that uses this values.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entitySettings()
    {
        return $this->hasMany(config('holo.entity_settings_model', EntitySetting::class));
    }
}
