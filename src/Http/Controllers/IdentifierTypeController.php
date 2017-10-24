<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Models\IdentifierType;

/**
 * Class IdentifierTypeController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class IdentifierTypeController extends Controller
{

    /**
     * IdentifierTypeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the identifier types.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return IdentifierType::all();
    }

}
