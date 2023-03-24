<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Hash;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\VerificationEmail;

use Illuminate\Support\Facades\URL;

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

        //Mail::to($user->email)->send(new VerificationEmail($user));
        //$user = User::findOrFail(1);
        Mail::to($user->email)->send(new VerificationEmail($user));

        //return URL::signedRoute('packets.show', ['packet' => 24]);
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
}
