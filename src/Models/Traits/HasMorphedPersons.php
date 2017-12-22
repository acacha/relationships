<?php

namespace Acacha\Relationships\Models\Traits;

use Acacha\Relationships\Models\Person;
use Acacha\Relationships\Scopes\WithPersonsScope;

/**
 * Class HasMorphedPersons.
 *
 * @package Acacha\Relationships\Models\Traits
 */
trait HasMorphedPersons
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
        return $this->morphToMany(Person::class, 'contactable')->withTimestamps()->orderBy('created_at','desc');
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