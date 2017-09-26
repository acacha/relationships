<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Address.
 *
 * @package Acacha\Relationships\Models
 */
class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'fullname',
        'type',
        'number',
        'floor',
        'floor_number',
        'postalcode',
        'location',
        'province_id',
        'country_code',
    ];

}
