<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Hash;

class RegisterController extends Controller
{
    /**
     * Handle account registration request
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $credencials = $request->validated();
        $credencials['password'] = Hash::make($credencials['password']);
        $user = User::create($credencials);
        //auth()->login($user);

        return $user;
    }
}
