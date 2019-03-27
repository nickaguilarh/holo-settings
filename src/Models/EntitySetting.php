<?php

namespace Holo;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 * @license MIT
 * @package Holo
 */

use Illuminate\Database\Eloquent\Model;

class EntitySetting extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table;

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

}
