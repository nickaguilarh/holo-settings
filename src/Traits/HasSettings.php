<?php


namespace Holo\Traits;


use Holo\EntitySetting;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasSettings
{
    /**
     * Retrieves all the settings for this model.
     * @return MorphMany
     */
    public function settings()
    {
        return $this->morphMany(EntitySetting::class, 'entity');
    }
}
