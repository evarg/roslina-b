<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Providers\UserServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use App\Services\ProducersService;
use App\Services\Dupa2;
use App\Services\Dupa;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Producer;
use App\Models\Packet;

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
        return new JsonResponse(
            [
            'user' => $user
            ],
            201
        );
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if (request('password')) {
            $credentials = [
                'email' => $user->email,
                'password' => $request->input('old_password'),
            ];

            if (!auth()->validate($credentials)) {
                return new JsonResponse(
                    [
                    "message" => "The old password is not valid.",
                    "errors" => [
                        "old_password" => [
                            "The old password field is not valid."
                        ]
                    ]
                    ],
                    422
                );
            }

            $user['password'] = Hash::make(request('password'));
        }

        $user['name'] = request('name');
        $user->save();

        return $user;
    }


    public function show(Request $request, User $user)
    {
        $user->load(['packets']);
        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }
}
