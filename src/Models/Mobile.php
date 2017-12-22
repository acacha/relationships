<?php

namespace Acacha\Relationships\Models;

use Acacha\Relationships\Models\Traits\HasMorphedPersons;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mobile.
 *
 * @package Acacha\Relationships\Models
 */
class Mobile extends Model
{
    use HasMorphedPersons;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['value'];

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function persons()
    {
        return $this->morphedByMany('App\Post', 'taggable');
    }
}
