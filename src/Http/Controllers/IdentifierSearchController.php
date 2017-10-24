<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\IdentifierSearch;
use Acacha\Relationships\Models\Identifier;

/**
 * Class IdentifierSearchController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class IdentifierSearchController extends Controller
{

    /**
     * Search for identifiers.
     */
    public function index(IdentifierSearch $request)
    {
        // existed or if no results found.
        $error = ['error' => 'No identifiers found, please try with different keywords.'];

        // Making sure the user entered a keyword.
        if($request->has('q')) {

            // Using the Laravel Scout syntax to search the products table.
            $identifiers = Identifier::where('value','like',$request->get('q') . '%')->get();

            // If there are results return them, if none, return the error message.
            return $identifiers->count() ? $identifiers : $error;

        }

        // Return the error message if no keywords existed
        return $error;
    }

}