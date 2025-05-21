<?php


namespace Holo\Traits;


use Holo\Models\AllowedSettingValue;
use Holo\Models\EntitySetting;
use Holo\Exceptions\ValueIsNotAllowedException;
use Illuminate\Cache\TaggableStore;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait HasSettings
{
    /**
     * @param string $settingName
     * @param $value
     * @param string $type
     *
     * @return EntitySetting
     * @throws ValueIsNotAllowedException
     */
    public function setSetting(string $settingName, $value, ?string $type = null)
    {
        $settingBase = $this->getSettingModel($settingName, $type);
        if ($settingBase->constrained) {
            return $this->setConstrainedEntitySetting($settingBase, $value);
        } else {
            return $this->setEntitySetting($settingBase, $value);
        }
    }

    /**
     * @param $settingName
     * @param string $type
     *
     * @return \Holo\Models\Setting|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private function getSettingModel($settingName, ?string $type = null)
    {
        $settingBase = \Holo\Models\Setting::whereName($settingName)->first();

        if (!$settingBase) {
            if (!$type) {
                $type = 'string';
            }
            $settingBase = \Holo\Models\Setting::create(
                [
                    'name' => $settingName,
                    'value_type' => $type,
                    'constrained' => false,
                ]
            );
        }

        return $settingBase;
    }

    private function castValue($type, $value)
    {
        settype($value, $type);
        return $value;
    }

    /**
     * @param \Holo\Models\Setting $setting
     * @param $value
     *
     * @return EntitySetting
     * @throws ValueIsNotAllowedException
     */
    private function setConstrainedEntitySetting(\Holo\Models\Setting $setting, $value)
    {
        if (!$setting->allowedValues()->whereValue($value)->exists()) {
            throw new ValueIsNotAllowedException(
                'This value is not allowed for this setting. Try one of this instead: ' .
                $setting->allowedValues->each(function (AllowedSettingValue $value) {
                    return $value->value . ' ';
                })
            );
        } else {
            return $this->setEntitySetting($setting, $value);
        }
    }

    private function setEntitySetting(\Holo\Models\Setting $setting, $value)
    {
        /** @var EntitySetting $entitySetting */
        $entitySetting = $this->settings()->firstOrNew(['setting_uuid' => $setting->uuid]);
        $entitySetting->setting()->associate($setting);
        if ($value instanceof AllowedSettingValue) {
            $entitySetting->constrainedValue()->associate($value);
            $entitySetting->value = $value->value;
        } else {
            $entitySetting->value = $value;
        }
        $entitySetting->save();
        return $entitySetting;
    }

    /**
     * Retrieves all the settings for this model.
     *
     * @return MorphMany
     */
    public function settings()
    {
        return $this->morphMany(EntitySetting::class, 'entity');
    }

    /**
     * @param string $settingName
     * @param null $value
     * @param string|null $type
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSetting(string $settingName, $value = null, string $type = null)
    {
        $settingBase = $this->getSettingModel($settingName);
        $entitySettings = $this->cachedSettings();
        $setting = $entitySettings->firstWhere('setting_uuid', $settingBase->uuid);
        $setting = $setting ? $setting->value : $value;
        if (!is_null($type)) {
            $castedValue = $this->castValue($type, $setting);
        } else {
            $castedValue = $this->castValue($settingBase->value_type, $setting);
        }

        if (!$setting) {
            return null;
        }
        return $castedValue;
    }

    public function cachedSettings()
    {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'settings_for_entity_id_' . $this->$rolePrimaryKey;
        if (Cache::getStore() instanceof TaggableStore && Config::get('holo.cache.enabled')) {
            return Cache::tags(Config::get('holo.settings_table'))->remember(
                $cacheKey,
                Config::get('holo.cache.ttl', 60),
                function () {
                    return $this->settings()->get();
                }
            );
        } else {
            return $this->settings()->get();
        }
    }
}
