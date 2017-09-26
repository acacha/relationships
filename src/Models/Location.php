<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Location.
 *
 * @package Acacha\Relationships\Models
 */
class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','postalcode'];
}
