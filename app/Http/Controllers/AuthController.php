<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        Log::info('message');
        $this->validateRegister($request);
        try {

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'address' =>
            $request->input('address'),
        ]);

            Log::info(json_encode($user));

        // if($user) {
            //return successful response
            return response()->json(['user' => $user, 'message' => 'User created successfully'], 201);
        // }
    } catch (\Exception $e) {
            //return error message
            Log::info(json_encode($e));
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
