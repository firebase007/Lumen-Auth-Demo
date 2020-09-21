<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Validators\ValidatesAuthenticationRequests;

class UserController extends Controller
{
    use ValidatesAuthenticationRequests;

    /**
     * UserController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth', ['except' => 'getUser']);
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserResource(Auth::user());
    }

    /**
     * Get the profile of the user given by their id
     *
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function getUser($id)
    {
        $user = $this->getUserById($id);
        // return new userResource($user);

        return response()->json($user);
    }

    /**
     * Retrieve user by their Id
     * @param  string $userId
     * @return \App\Models\User
     */
    protected function getUserById(string $id)
    {
        if (!$user = User::findOrFail($id)) {
            abort(404, "User with ${id} not found");
        }
        return $user;
    }



    /**
     * Get all User.
     *
     * @return Response
     */
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);

    }


}
