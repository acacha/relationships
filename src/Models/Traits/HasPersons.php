<?php

namespace Acacha\Relationships\Models\Traits;

use Acacha\Relationships\Models\Person;

/**
 * Class HasPersons.
 *
 * @package Acacha\Relationships\Models\Traits
 */
trait HasPersons
{
    /**
     * Get the phone record associated with the user.
     */
    public function persons()
    {
        return $this->belongsToMany(Person::class);
    }
}