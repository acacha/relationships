<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ListUserPhoto;
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
     * Show all resources in storage for an specified user
     */
    public function index(ListUserPhoto $request, User $user)
    {
        abort_unless($user->person != null,404);
        return $user->person->photos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserPhoto $request
     * @param User $user
     * @return mixed
     */
    public function store(StoreUserPhoto $request, User $user)
    {
        $person_id = null;

        if ($user->person) $person_id = $user->person->id;
        else {
            $user->persons()->attach($person = Person::draft());
            $person_id = $person->id;
        }
        return $this->storePersonPhoto($request, $person_id);
    }

}
