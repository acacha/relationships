<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country.
 *
 * @package Acacha\Relationships\Models
 */
class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','type_id'];
}
