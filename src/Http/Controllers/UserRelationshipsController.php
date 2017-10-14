<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\ShowRelationshipsUser;
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
     * Display the user info with relationships info.
     *
     * @param ShowRelationshipsUser $request
     * @param User|null $user
     * @return mixed
     */
    public function show(ShowRelationshipsUser $request, User $user = null)
    {
        if ($user) return $user->load(['persons'])->append('person');
        return Auth::user()->load(['persons'])->append('person');
    }

}
