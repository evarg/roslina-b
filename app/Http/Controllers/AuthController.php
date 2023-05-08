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
     * @OA\Post(
     *   path="/auth",
     *   summary="Login user",
     *   description="Login user with valid crednecials and return token",
     *   tags={"auth"},
     *   @OA\Parameter(
     *     in="query",
     *     name="email",
     *     required=true,
     *     @OA\Schema(
     *       type="string",
     *       format="email"
     *     )
     *   ),
     *   @OA\Parameter(
     *     in="query",
     *     name="password",
     *     required=true,
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *       @OA\Property(property="token", type="string"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Invalid credencials",
     *     @OA\JsonContent(
     *       @OA\Property(property="code", type="string", example="auth.invalid_credencials"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="No required fields",
     *     @OA\JsonContent(
     *       ref="#/components/schemas/apiResponse422")
     *     ),
     *   ),
     * )
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
     * @OA\Get(
     *   path="/auth",
     *   summary="Get logged in user",
     *   description="Logout user and destroy all user's tokens",
     *   tags={"auth"},
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Non authorized",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Non authorized"),
     *     )
     *   ),
     * )
     */
    public function show()
    {
        $user = Auth::user();
        return new JsonResponse(["user" => $user]);
    }

    /**
     * @OA\Delete(
     *   path="/auth",
     *   summary="Logout user",
     *   description="Logout user and destroy all user's tokens",
     *   tags={"auth"},
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="auth.logout_success"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Non authorized",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Non authorized"),
     *     )
     *   ),
     * )
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
