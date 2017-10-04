<?php

namespace Acacha\Relationships\Http\Requests\Traits;

use Auth;

/**
 * Class CheckPhotoIsOwnedByUser.
 */
trait CheckPhotoIsOwnedByUser
{
    /**
     * Is photo owned by user.
     *
     * @return bool
     */
    protected function isPhotoOwnedByUser()
    {
        if ( ! $persons = Auth::user()->persons) return false;
        foreach ($persons as $person) {
            if ($person->id == $this->route('id')) return true;
        }
        return false;
    }
}