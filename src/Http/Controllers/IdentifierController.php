<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ListIdentifiers;
use Acacha\Relationships\Models\Identifier;

/**
 * Class IdentifierController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class IdentifierController extends Controller
{
    /**
     * Show all identifiers.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(ListIdentifiers $request)
    {
        $identifiers = [];
        // NOTE: avoid retrieving all persons relationship to avoid crossed relations loop!
        foreach (Identifier::has('persons')->with(array('persons'=>function($query){
            $query->select('people.id');
        }))->get() as $identifier) {

            $identifiers[] = [
                'id' => $identifier->id,
                'value' => $identifier->value,
                'type_id' => $identifier->type_id,
                'type_name' => $identifier->type_name,
                'person_id' => $identifier->persons()->first()->pivot->person_id
            ];
        }

        return $identifiers;

    }
}