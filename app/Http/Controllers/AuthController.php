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
     * @OA\Schema(
     *     schema="profileGet",
     * allOf={
     *    @OA\Schema(
     *       @OA\Property(property="categories", type="array", @OA\Items(ref="#/components/schemas/User")),
     *    )
     * }
     * )
     *
     * @OA\Get(
     * path="/v1/profile",
     * summary="Retrieve profile information",
     * description="Get profile short information",
     * operationId="profileShow",
     * tags={"profile"},
     * security={ {"bearer": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object", ref="#/components/schemas/profileGet")
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="User should be authorized to get profile information",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
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
