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
        return Identifier::all();
    }
}