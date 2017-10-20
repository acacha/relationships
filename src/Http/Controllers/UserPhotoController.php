<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\StoreUserPhoto;

use Acacha\Relationships\Models\Person;
use App\User;

/**
 * Class UserPhotoController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class UserPhotoController extends PhotoController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @return mixed
     */
    public function store(StoreUserPhoto $request, $id)
    {
        $user = User::findOrFail($id);
        $person_id = null;
        if ($user->person) $person_id = $user->person->id;
        else {
            $user->persons()->attach($person = Person::draft());
            $person_id = $person->id;
        }
        return $this->storePersonPhoto($request, $person_id);
    }

}
