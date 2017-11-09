<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ShowPerson;
use Acacha\Relationships\Http\Requests\UpdatePerson;
use Acacha\Relationships\Models\Identifier;
use Acacha\Relationships\Models\Person;
use Acacha\Relationships\Http\Requests\StorePerson;
use Illuminate\Http\Request;

/**
 * Class PersonController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class PersonController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePerson $request
     */
    public function store(StorePerson $request)
    {
        $identifier = $this->storeIdentifier($request);
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
        if ($identifier) $person->identifier()->associate($identifier);
        $person->save();
        return $person;

    }

    /**
     * Update person.
     *
     * @param UpdatePerson $request
     * @param Person $person
     * @return Person
     */
    public function update(UpdatePerson $request, Person $person)
    {
        $identifier = $this->updateIdentifier($request, $person);
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
        if ($identifier) $person->identifiers()->attach($identifier->id);

        return $person;
    }

    /**
     * Store identifier.
     *
     * @param $request
     * @return null
     */
    protected function storeIdentifier($request)
    {
        $identifier = $request->input('identifier');
        $type = $request->input('identifier_type');
        if ($identifier) {
            return Identifier::firstOrCreate([
                'value' => $identifier,
                'type_id' => $type
            ]);
        }
        return null;
    }

    /**
     *  Update identifier.
     *
     * @param $request
     * @param Person $person
     * @return null
     */
    protected function updateIdentifier($request, Person $person)
    {
        $identifier = $request->input('identifier');
        $type = $request->input('identifier_type');
        if ($identifier) {
            $identifier = Identifier::firstOrNew([
                'value' => $identifier,
                'type_id' => $type
            ]);
            if ($identifier->exists) {
                // TODO ????
            } else {
                $identifier->save();
            }
        } else {
            $person->identifiers();
        }
        return null;
    }

}