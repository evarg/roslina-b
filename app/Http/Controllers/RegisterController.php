<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Hash;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\RegistrationMail;

use App\Mail\SendDemoMail;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ForgotParswordMail;
use Illuminate\Auth\Notifications\ResetPassword;
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
        //        $email = 'grave432@gmail.com';
        $credencials = $request->validated();
        $credencials['password'] = Hash::make($credencials['password']);

        //$user = User::findOrFail(26);
        $user = User::create($credencials);
        $maildata = [
            'subject' => 'Aktywacja konta użytkownika w systemie roslina.com.pl',
            'userName' => $user->name,
            'url' => URL::signedRoute('email.verify', ['id' => $user->id])
        ];

        Mail::to($user->email)->send(new RegistrationMail($maildata));
        return $user;

        //auth()->login($user);

        //Mail::to($user->email)->send(new VerificationEmail($user));
        //Mail::to($user->email)->send(new VerificationEmail($user));

        //return URL::signedRoute('packets.show', ['packet' => 24]);
        //return $user;
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

    public function resetPassword(ResetPasswordRequest $request)
    {
        $credencials = $request->validated();

        //$user = User::findOrFail(26);
        //$user = User::create($credencials);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        $user = User::where('email', $request->email)->first();
        //$user->generatePasswordResetToken();
        $maildata = [
            'subject' => 'Reset hasła konta użytkownika w systemie roslina.com.pl',
            'userName' => $user->name,
            'url' => $status
        ];

        $hw = ResetPassword::createUrlUsing(function (User $user, string $token) {
            return 'https://example.com/reset-password?token='.$token;
        });

        //Mail::to($user->email)->send(new ForgotParswordMail($maildata));
        return Password::broker()->createToken($user);;


    }
}
