<?php

use Acacha\Relationships\Models\Contact;
use Acacha\Relationships\Models\ContactType;
use Acacha\Relationships\Models\Identifier;
use Acacha\Relationships\Models\IdentifierType;

if (! function_exists('seed_postalcodes')) {
    function seed_postalcodes()
    {
        //
    }
}

if (! function_exists('first_or_create_codigo_postal')) {
    function first_or_create_codigo_postal($postalcode, $location)
    {
        //
    }
}

if (! function_exists('first_or_create_contact_type')) {
    /**
     * Create contact type if not exists and return new o already existing contact type.
     */
    function first_or_create_contact_type($name)
    {
        try {
            return ContactType::create(['name' => $name]);
        } catch (Illuminate\Database\QueryException $e) {
            return ContactType::where('name', $name);
        }
    }
}

if (! function_exists('seed_contact_types')) {
    /**
     * Create contact_types.
     */
    function seed_contact_types()
    {
        first_or_create_contact_type('Telèfon');
        first_or_create_contact_type('email');
        first_or_create_contact_type('TODO');
    }
}

if (! function_exists('obtainContactTypeByName')) {
    /**
     * Obtain contact type by name.
     */
    function obtainContactTypeByName($name)
    {
        ContactType::where('name',$name)->first()->id;
    }
}

if (! function_exists('first_or_create_contact')) {
    /**
     * Create contact if not exists and return new o already existing contact.
     */
    function first_or_create_contact($value, $type)
    {
        try {
            return Contact::create([
                'value' => $value,
                'contact_type_id' => obtainContactTypeIdByName($type)
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return Contact::where('value', $value);
        }
    }
}

if (! function_exists('obtainContactTypeIdByName')) {
    /**
     * Obtain contact type id by name.
     */
    function obtainContactTypeIdByName($name)
    {
        return ContactType::where('name', $name)->first()->id;
    }
}


if (! function_exists('first_or_create_identifier_type')) {
    /**
     * Create contact type if not exists and return new o already existing contact type.
     */
    function first_or_create_identifier_type($name)
    {
        try {
            return IdentifierType::create(['name' => $name]);
        } catch (Illuminate\Database\QueryException $e) {
            return IdentifierType::where('name', $name);
        }
    }
}

if (! function_exists('seed_identifier_types')) {
    /**
     * Create identifier types.
     */
    function seed_identifier_types()
    {
        first_or_create_identifier_type('NIF');
        first_or_create_identifier_type('Pasaporte');
        first_or_create_identifier_type('NIE');
        first_or_create_identifier_type('TIS');
        first_or_create_identifier_type('TODO');
    }
}


if (! function_exists('first_or_create_identifier')) {
    /**
     * Create identifier if not exists and return new o already existing identifier.
     */
    function first_or_create_identifier($value, $type)
    {
        try {
            return Identifier::create([
                'value' => $value,
                'type_id' => $type
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return Contact::where('value', $value);
        }
    }
}



if (! function_exists('seed_relationships')) {
    function seed_relationships()
    {
        seed_identifier_types();
        seed_contact_types();
    }
}