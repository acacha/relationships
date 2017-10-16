<?php

namespace Acacha\Relationships\Http\Requests\Traits;

use Auth;

/**
 * Trait UserOwns.
 */
trait UserOwns
{
    /**
     * Is resource owned by user
     *
     * @return bool
     */
    protected function owns($id = null)
    {
        $id ?: $id = $this->route('id');
        if (Auth::user()->id == $id) return true;
        return false;
    }
}