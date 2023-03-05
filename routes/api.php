<?php

use App\Http\Controllers\PacketController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UploadController;
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
Route::get('packets/{id}/remove_file/{fileId}', [PacketController::class, 'removeFile']);


Route::apiResource('producers', ProducerController::class);
Route::apiResource('files', FileController::class);
Route::apiResource('upload', UploadController::class);

