<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="roslina.com.pl documentation",
 *      description="System zarządzania domową rozsadą",
 *      @OA\Contact(
 *          email="grave432@gmail.com"
 *      ),
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="roslina.poligon"
 * )
 * @OA\Schema(
 *   schema="apiResponse422",
 *   @OA\Property(property="message", type="string"),
 *   @OA\Property(property="errors", type="object",
 *     @OA\Property(property="email", type="array",
 *       @OA\Items(type="string", example="The email field is required.")
 *     ),
 *   ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
