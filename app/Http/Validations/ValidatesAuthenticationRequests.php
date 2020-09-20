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
            'user.email'    => 'required|email|max:255',
            'user.password' => 'required| string',
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
            'user.name' => 'required|max:50|alpha_num|unique:users,name',
            'user.email'    => 'required|email|max:255|unique:users,email',
            'user.password' => 'required|min:8',
            'user.address' => 'required|alpha'
        ]);
    }
}
