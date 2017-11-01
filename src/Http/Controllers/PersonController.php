<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ShowPerson;
use Acacha\Relationships\Models\Person;
use Acacha\Relationships\Http\Requests\StorePerson;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePerson $request
     */
    public function store(StorePerson $request)
    {
//        dd($request->input());

        $person = Person::create( $request->only([
            'identifier_id',
            'givenName',
            'identifier_id',
            'surname1',
            'surname2',
            'birthdate',
            'birthplace_id',
            'gender',
        ]));

        return $person;

//        array:7 [
//            "identifier_id" => null
//            "givenName" => null
//            "surname1" => null
//            "surname2" => null
//            "birthdate" => null
//            "birthplace_id" => null
//            "gender" => null]

//        array:18 [
//        "givenName" => "Jimena"
//  "surname1" => "Montero"
//  "surname2" => "Olivas"
//  "birthdate" => "1929-03-15 00:00:00"
//  "birthplace_id" => 2
//  "gender" => "female"
//  "civil_status" => "Separado/a"
//  "notes" => "Ut iste ut non aut esse."
//  "state" => "valid"
//  "updated_at" => "2017-10-31 11:22:48"
//  "created_at" => "2017-10-31 11:22:48"
//  "id" => 1
//  "identifier" => "84370530K"
//  "identifier-id" => 1
//  "identifier-type" => 1
//  "birthplace-name" => "L'Aldea"
//  "identifiers" => array:1 [
//        0 => array:8 [
//        "id" => 1
//      "value" => "84370530K"
//      "type_id" => 1
//      "created_at" => "2017-10-31 11:22:48"
//      "updated_at" => "2017-10-31 11:22:48"
//      "type_name" => "NIF"
//      "pivot" => array:4 [
//        "person_id" => 1
//        "identifier_id" => 1
//        "created_at" => "2017-10-31 11:22:48"
//        "updated_at" => "2017-10-31 11:22:48"
//      ]
//      "type" => array:4 [
//        "id" => 1
//        "name" => "NIF"
//        "created_at" => "2017-10-31 11:22:48"
//        "updated_at" => "2017-10-31 11:22:48"
//      ]
//    ]
//  ]
//  "birthplace" => array:5 [
//        "id" => 2
//    "name" => "L'Aldea"
//    "postalcode" => "43896"
//    "created_at" => "2017-10-31 11:22:48"
//    "updated_at" => "2017-10-31 11:22:48"
//  ]
//]
    }
}