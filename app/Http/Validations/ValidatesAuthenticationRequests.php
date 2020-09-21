<?php

namespace App\Http\Validators;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

trait ValidatesAuthenticationRequests
{
    /**
     * Validate login request input
     *
     * @param  Request $request
     * @throws \Illuminate\Auth\Access\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required| string',
        ]);
    }

    /**
     * Validate register request input
     *
     * @param  Request $request
     * @throws \Illuminate\Auth\Access\ValidationException
     */
    protected function validateRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50|unique:users,name',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'required'
        ]);
    }
}
