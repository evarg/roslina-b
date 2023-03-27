<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Hash;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\RegistrationMail;

use Illuminate\Support\Facades\URL;
use App\Http\Requests\ResetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

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
        $maildata = [
            'subject' => 'Aktywacja konta użytkownika w systemie roslina.com.pl',
            'userName' => $user->name,
            'url' => URL::signedRoute('email.verify', ['id' => $user->id])
        ];

        Mail::to($user->email)->send(new RegistrationMail($maildata));
        return $user;
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));
        if ($user->markEmailAsVerified()) {
            return response()->json([
                'message' => 'Email verified'
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $response = Password::broker()->sendResetLink(
            array_merge($request->only('email'))
        );

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return new JsonResponse('responseOk', 201);
            default:
                return new JsonResponse('UNKNOWN ERROR', 422);
        }
    }

    public function reset(ResetRequest $request)
    {
        $credentials = array_merge($request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ));

        $response = Password::broker()
            ->reset($credentials, function ($user, $password) {
                $user->password = Hash::make($password);
                $user->password = $password;
                $user->save();
            });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return new JsonResponse('responseOk', 201);
            default:
                return new JsonResponse('UNKNOWN ERROR', 422);
        }
    }
}
