<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ShowLoggedUserPerson;
use Acacha\Relationships\Http\Requests\StoreLoggedUserPerson;
use Acacha\Relationships\Http\Requests\UpdateLoggedUserPerson;
use Acacha\Relationships\Models\Person;
use App\Http\Controllers\Controller;
use Auth;

/**
 * Class LoggedUserPersonController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class LoggedUserPersonController extends Controller
{
    /**
     * Show person associated to logged user.
     *
     * @param ShowLoggedUserPerson $request
     * @return mixed
     */
    public function show(ShowLoggedUserPerson $request)
    {
        return Auth::user()->person;
    }

    /**
     * Store person to logged user.
     *
     * @param StoreLoggedUserPerson $request
     * @return mixed
     */
    public function store(StoreLoggedUserPerson $request)
    {
        $person = Person::create( $request->only([
            'givenName',
            'surname1',
            'surname2',
            'birthdate',
            'birthplace_id',
            'gender',
            'notes',
            'civil_status',
        ]));
        Auth::user()->persons()->save($person);
        return $person;
    }

    /**
     * Update person associated to logged user.
     *
     * @param UpdateLoggedUserPerson $request
     * @return mixed
     */
    public function update(UpdateLoggedUserPerson $request)
    {
        $person = Auth::user()->person;
        if (!$person) abort(404);
        $person->update( $request->only([
            'givenName',
            'surname1',
            'surname2',
            'birthdate',
            'birthplace_id',
            'gender',
            'notes',
            'civil_status',
        ]));

        return $person;
    }

}