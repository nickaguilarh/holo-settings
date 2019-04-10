<?php


namespace Holo\Traits;


use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait Setting
{
    public function cachedSettings()
    {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'settings_for_' . $this->$rolePrimaryKey;
        if (Cache::getStore() instanceof TaggableStore && Config::get('holo.cache.enabled')) {
            return Cache::tags(Config::get('holo.settings_table'))->remember(
                $cacheKey,
                Config::get('holo.cache.ttl', 60),
                function () {
                    return $this->entitySettings()->get();
                }
            );
        } else {
            return $this->entitySettings()->get();
        }
    }

    public function cachedEntitySettings()
    {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'entity_settings_for' . $this->$rolePrimaryKey;
        if (Cache::getStore() instanceof TaggableStore && Config::get('holo.cache.enabled')) {
            return Cache::tags(Config::get('holo.entity_settings_table'))->remember(
                $cacheKey,
                Config::get('holo.cache.ttl', 60),
                function () {
                    return $this->allowedValues()->get();
                }
            );
        } else {
            return $this->allowedValues()->get();
        }
    }

    public function save(array $options = [])
    {
        if (!parent::save($options)) {
            return false;
        }
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('holo.allowed_setting_values_table'))->flush();
        }
        return true;
    }

    public function delete(array $options = [])
    {
        if (!parent::delete($options)) {
            return false;
        }
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('holo.allowed_setting_values_table'))->flush();
        }
        return true;
    }

    public function restore()
    {
        if (!parent::restore()) {
            return false;
        }
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('holo.allowed_setting_values_table'))->flush();
        }
        return true;
    }
}
