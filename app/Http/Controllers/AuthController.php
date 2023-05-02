<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\ErrorCode;
use App\Helpers\MessageCode;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ResetPassword;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\StoreAuthRequest;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Log in user.
     *
     * @param StoreAuthRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAuthRequest $request)
    {
        $credencials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credencials)) {
            return ApiResponse::error(ErrorCode::AUTH_INVALID_CREDENCIALS, 401);
        }

        $user = User::where('email', $request->email)->first();

        return new JsonResponse(
            [
            'user' => $user,
            'token' => $user->createToken('Angular.token')->plainTextToken,
            ],
            201
        );
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        auth()->logout();
        return new JsonResponse(['message' => MessageCode::AUTH_LOGOUT_SUCCESS], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        //return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json(
            [
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()-> ->factory()->getTTL() * 60
            ]
        );
    }


    public function reset(ResetPassword $request)
    {
        $credentials = array_merge(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            ['deleted' => 0, 'activated' => 1]
        );

        // try to change user password
        $response = Password::broker()
            ->reset(
                $credentials,
                function ($user, $password) {
                    $user->password = $password;
                    $user->save();
                }
            );

        // return valid response based on Password broker response
        return $response;
    }
}
