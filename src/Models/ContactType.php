<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContactType.
 *
 * @package Acacha\Relationships\Models
 */
class ContactType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}