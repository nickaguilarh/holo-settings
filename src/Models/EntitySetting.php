<?php

namespace Holo;

use Eloquent;
use Holo\Relationships\EntitySettingRelationships;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read AllowedSettingValue $constrainedValue
 * @property-read Collection|EntitySetting[] $entity
 * @property-read Setting|null $setting
 * @method static Builder|EntitySetting newModelQuery()
 * @method static Builder|EntitySetting newQuery()
 * @method static Builder|EntitySetting query()
 * @method static Builder|EntitySetting whereCreatedAt($value)
 * @method static Builder|EntitySetting whereDeletedAt($value)
 * @method static Builder|EntitySetting whereEntityId($value)
 * @method static Builder|EntitySetting whereEntityType($value)
 * @method static Builder|EntitySetting whereSettingUuid($value)
 * @method static Builder|EntitySetting whereUpdatedAt($value)
 * @method static Builder|EntitySetting whereUuid($value)
 * @method static Builder|EntitySetting whereValue($value)
 * @method static Builder|EntitySetting whereValueUuid($value)
 * @mixin Eloquent
 */
class EntitySetting extends Model
{
    use EntitySettingRelationships;
    use Traits\EntitySetting;

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

    /*
  * Defines the properties that should be mass assignable.
  *
  * @var string
  */
    protected $fillable = [
        'setting_uuid',
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
