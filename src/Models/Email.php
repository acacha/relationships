<?php

namespace Acacha\Relationships\Models;

use Acacha\Relationships\Models\Traits\HasMorphedPersons;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Email.
 *
 * @package Acacha\Relationships\Models
 */
class Email extends Model
{
    use HasMorphedPersons;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['value'];

}
