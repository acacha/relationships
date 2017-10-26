<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ListFullnames;
use Acacha\Relationships\Models\Person;

/**
 * Class FullNameController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class FullNameController  extends Controller
{
    /**
     * Show all identifiers.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(ListFullnames $request)
    {
        $fullnames = [];
        foreach (Person::finished()->get() as $person) {
            $fullnames[] = [
              'name' => $person->name,
              'identifier' => $person->identifier,
              'identifier_id' => $person->identifier_id,
              'id' => $person->id
            ];
        }

        return $fullnames;
    }
}