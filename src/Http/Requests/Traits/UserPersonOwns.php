<?php

namespace Acacha\Relationships\Http\Requests\Traits;

use Auth;

/**
 * Trait UserPersonOwns.
 */
trait UserPersonOwns
{
    /**
     * Is person owned by logged user.
     *
     * @param null $id
     * @return bool
     */
    protected function userPersonOwns($id = null)
    {
        $id ?: $id = $this->person->id;
        if (Auth::user()->person) {
            if (Auth::user()->person->id == $id) return true;
        }
        return false;
    }
}