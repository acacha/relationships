<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ListLocations;
use Acacha\Relationships\Models\Location;

/**
 * Class LocationController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class LocationController extends Controller
{
    /**
     * Show all locations
     */
    public function index(ListLocations $request)
    {
        return Location::all();
    }
}