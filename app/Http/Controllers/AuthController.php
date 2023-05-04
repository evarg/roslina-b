<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Helpers\ErrorCode;
use App\Helpers\MessageCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthRequest;
use App\Models\User;

class AuthController extends Controller
{
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
        $user = Auth::user();
        return new JsonResponse($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        Auth::forgetGuards();

        return new JsonResponse(
            [
                'message' => MessageCode::AUTH_LOGOUT_SUCCESS
            ],
            200
        );
    }
}
