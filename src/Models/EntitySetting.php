<?php

namespace Holo;

use Holo\Relationships\EntitySettingRelationships;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Holo\EntitySetting
 * This file is part of Holo Settings,
 * a settings solution for Laravel.
 *
 * @license MIT
 * @package Holo Setting
 * @property string $uuid
 * @property string $entity_type
 * @property int $entity_id
 * @property string|null $value
 * @property string|null $value_uuid
 * @property string|null $setting_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Holo\AllowedSettingValue $constrainedValue
 * @property-read \Illuminate\Database\Eloquent\Collection|EntitySetting[] $entity
 * @property-read \Holo\Setting|null $setting
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereSettingUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntitySetting whereValueUuid($value)
 * @mixin \Eloquent
 */
class EntitySetting extends Model
{
    use EntitySettingRelationships;

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
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'constrainedValue',
        'setting'
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('holo.entity_settings_table', 'entity_settings');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (EntitySetting $entitySetting) {
            $entitySetting->uuid = Uuid::uuid4();
        });
    }
}
