<?php

namespace Acacha\Relationships\Models;

use Acacha\Relationships\Models\Traits\HasMorphedPersons;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Phone.
 *
 * @package Acacha\Relationships\Models
 */
class Phone extends Model
{
    use HasMorphedPersons;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['value'];

}
