<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ShowUserRelationships;
use App\User;
use Auth;

/**
 * Class UserRelationshipsController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class UserRelationshipsController extends Controller
{

    /**
     * UserRelationshipsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user relationships.
     *
     * @param $id
     * @return mixed
     */
    public function show(ShowUserRelationships $request, $id = null)
    {
        $user = null;
        if ($id) $user = User::with(['persons','roles','permissions'])->findOrFail($id);
        else $user = Auth::user()->with('persons','roles','permissions')->first();
        return $user;
    }


}
