<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ShowPerson;
use Acacha\Relationships\Models\Person;

/**
 * Class PersonController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class PersonController  extends Controller
{
    /**
     * Show person.
     *
     * @param ShowPerson $request
     * @param Person $person
     * @return Person
     */
    public function show(ShowPerson $request, Person $person)
    {
        return $person;
    }
}