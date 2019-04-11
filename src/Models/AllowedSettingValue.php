<?php

namespace Holo;

use Holo\Relationships\AllowedSettingValueRelationships;
use Holo\Traits\AllowedSetting;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Holo\AllowedSettingValue
 * This file is part of Holo Settings,
 * a settings solution for Laravel.
 *
 * @license MIT
 * @package Holo Settings
 * @property string $uuid
 * @property string $setting_uuid
 * @property string $value
 * @property string $caption
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Holo\EntitySetting[] $entitySettings
 * @property-read \Holo\Setting $setting
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue whereSettingUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllowedSettingValue whereValue($value)
 * @mixin \Eloquent
 */
class AllowedSettingValue extends Model
{
    use AllowedSettingValueRelationships;
    use AllowedSetting;

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
        $this->table = config('holo.allowed_setting_values_table', 'allowed_setting_values');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (AllowedSettingValue $allowedSettingValue) {
            $allowedSettingValue->uuid = Uuid::uuid4();
        });
    }
}
