<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Validators\ValidatesAuthenticationRequests;


class AuthController extends Controller
{
    use ValidatesAuthenticationRequests;

    /**
     * Login user and return the user is successful.
     *  Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials =
        $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return $this->respondFailedLogin();
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register a new user and return the user if successful.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
        $this->validateRegister($request);

        $user = User::create([
            'name' => $request->input('user.username'),
            'email' => $request->input('user.email'),
            'password' => Hash::make($request->input('user.password')),
            'address' =>
            $request->input('user.address'),
        ]);

        if($user) {
            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);
        }
    } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    /**
     * Respond with failed login.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondFailedLogin()
    {
        return $this->respond([
            'errors' => [
                'email or password' => ['is invalid'],
            ]
        ], 422, false);
    }
}
