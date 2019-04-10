<?php

namespace Holo;

use Holo\Constraints\ConstraintsContract;
use Holo\Constraints\SettingsConstraints;
use Holo\Models\ConstraintsAbstract;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Holo\Setting
 * This file is part of Holo Settings,
 * a settings solution for Laravel.
 *
 * @license MIT
 * @package Holo Settings
 * @property string $uuid
 * @property string $name
 * @property int $constrained
 * @property string $value_type
 * @property float|null $min_value
 * @property float|null $max_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereConstrained($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereMaxValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereMinValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValueType($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Holo\AllowedSettingValue[] $allowedValues
 * @property-read \Illuminate\Database\Eloquent\Collection|\Holo\EntitySetting[] $entitySettings
 */
class Setting extends Model
{

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('holo.settings_table', 'settings');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Setting $setting) {
            $setting->uuid = Uuid::uuid4();
            $this->registerConstraints();
            $this->validateConstraints();
        });
    }

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
