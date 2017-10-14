<?php

namespace Acacha\Relationships\Models\Traits;

use Acacha\Relationships\Models\Person;
use Acacha\Relationships\Scopes\WithPersonsScope;

/**
 * Class HasPersons.
 *
 * @package Acacha\Relationships\Models\Traits
 */
trait HasPersons
{

    public static function bootHasPersons()
    {
        static::addGlobalScope(new WithPersonsScope());
    }

    /**
     * Get the persons records associated with the user.
     */
    public function persons()
    {
        return $this->belongsToMany(Person::class)->withTimestamps()->orderBy('created_at','desc');
    }

    /**
     * Get person info for user.
     *
     * @param  string  $value
     * @return string
     */
    public function getPersonAttribute($value)
    {
        return $this->persons()->first();
    }

}