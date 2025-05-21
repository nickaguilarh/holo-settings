<?php


namespace Holo\Relationships;


use Holo\Models\AllowedSettingValue;
use Holo\Models\Setting;

trait EntitySettingRelationships
{
    /**
     * Retrieves the entity for this setting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Retrieve the value when the setting is constrained.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function constrainedValue()
    {
        return $this->belongsTo(config('holo.allowed_setting_values_model', AllowedSettingValue::class), 'value_uuid');
    }

    /**
     * Retrieves the setting configuration for this setting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting()
    {
        return $this->belongsTo(config('holo.settings_model', Setting::class));
    }
}
