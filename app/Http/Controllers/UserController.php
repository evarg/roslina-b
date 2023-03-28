<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Providers\UserServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;

class UserController extends Controller
{
    /**
     * Creates new user.
     *
     * @param StoreUserRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $credencials = $request->validated();
        $credencials['password'] = Hash::make($credencials['password']);

        $user = User::create($credencials);
        $maildata = [
            'subject' => 'Aktywacja konta użytkownika w systemie roslina.com.pl',
            'userName' => $user->name,
            'url' => URL::signedRoute('email.verify', ['id' => $user->id])
        ];

        Mail::to($user->email)->send(new RegistrationMail($maildata));
        return new JsonResponse([
            'user' => $user
        ], 201);
    }
}
