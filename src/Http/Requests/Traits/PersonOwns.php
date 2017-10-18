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
    protected function personOwns($resourceId = null)
    {
        if ($resourceId == null)  $resourceId = $this->route('id');
        if ( ! $persons = Auth::user()->persons) abort(404);
        if ( $persons->count() == 0) abort(404);
        foreach ($persons as $person) {
            if ($person->id == $resourceId) return true;
        }
        return false;
    }
}