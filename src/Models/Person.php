<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 *
 * @package Acacha\Relationships\Models
 */
class Person extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'givenName',
        'surname',
        'surname1',
        'surname2',
        'birthdate',
        'birthplace_id',
        'gender',
        'civil_status',
    ];

}
