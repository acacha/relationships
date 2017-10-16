<?php

namespace Acacha\Relationships\Http\Requests\Traits;

use Auth;

/**
 * Trait PersonOwns.
 */
trait PersonOwns
{
    /**
     * Is resource owned by person.
     *
     * @return bool
     */
    protected function personOwns()
    {
        if ( ! $persons = Auth::user()->persons) abort(404);
        if ( $persons->count() == 0) abort(404);
        foreach ($persons as $person) {
            if ($person->id == $this->route('id')) return true;
        }
        return false;
    }
}