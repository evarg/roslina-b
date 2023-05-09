<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PacketController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TestAllController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Models\Packet;
use App\Models\Producer;

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

Route::apiResource('files', FileController::class);
Route::apiResource('upload', UploadController::class);

Route::apiResource('images', ImageController::class);

Route::get('status', [App\Http\Controllers\AuthController::class, 'status']);

Route::post('register', [RegisterController::class, 'register']);
Route::get('/email/verify', [RegisterController::class, 'show']);
Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verify']);
//Route::post('/email/resend', [RegisterController::class, 'resend']);
Route::post('/reset_password', [RegisterController::class, 'reset']);
Route::get('/reset_password', [RegisterController::class, 'resetPassword'])->name('password.reset');

Route::model('producer', 'App\Models\Producer');
Route::model('packet', 'App\Models\Packet');
Route::get('/test/{producer}/{packet}', [UserController::class, 'test']);

// Route::post('refresh', 'AuthController@refresh');

Route::get('/email/verify/{id}', [RegisterController::class, 'verify'])
    ->name('email.verify')
    ->middleware('signed');



Route::apiResource('testall', TestAllController::class);

/*
|--------------------------------------------------------------------------
| API Routes - Refactor
|--------------------------------------------------------------------------
|
*/

/*
    Auth
*/
Route::post('auth', [AuthController::class, 'store'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('auth', [AuthController::class, 'destroy'])->name('logout');
    Route::get('auth', [AuthController::class, 'show'])->name('me');
});

/*
    Producers
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('producers', ProducerController::class);
});


/*
    Tests etc.
*/
Route::apiResource('search', SearchController::class);
Route::apiResource('search/:search', SearchController::class);

Route::middleware('api_autt')->group(function () {
    Route::get('testuncio', function () {
        //$test = Packet::with('producer')->ByProducer(25);
        $p = Packet::where('id', '<', 16)->ByProducer(25);

        //$test = $p->packets()->get();
//        $test->w
        return $p;
    });
});


Route::post('users', [UserController::class, 'store']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::get('users/{user}', [UserController::class, 'show']);
