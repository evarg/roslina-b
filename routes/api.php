<?php

use App\Http\Controllers\PacketController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

use App\Models\Packet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('packets', PacketController::class);

Route::get('packets/{id}/add_file/{fileId}', [PacketController::class, 'addFile']);
Route::post('packets/{id}/add_file_upload', [PacketController::class, 'addFileUpload']);
Route::get('packets/{id}/remove_file/{fileId}', [PacketController::class, 'removeFile']);
Route::get('packets2/{id}', [PacketController::class, 'show2']);

Route::apiResource('producers', ProducerController::class);
Route::apiResource('files', FileController::class);
Route::apiResource('upload', UploadController::class);

Route::get('status', [App\Http\Controllers\AuthController::class, 'status']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [RegisterController::class, 'register']);
// Route::post('refresh', 'AuthController@refresh');
Route::post('me', [AuthController::class, 'me']);
