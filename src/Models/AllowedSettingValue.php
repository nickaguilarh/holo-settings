<?php

namespace Holo;

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 * @license MIT
 * @package Holo
 */

use Illuminate\Database\Eloquent\Model;

class AllowedSettingValue extends Model
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
        $this->table = config('holo.allowed_setting_values_table', 'allowed_setting_values');
    }

}
