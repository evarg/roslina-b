<?php

use App\Http\Controllers\PacketController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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
Route::post('me', [AuthController::class, 'me']);

Route::post('register', [RegisterController::class, 'register']);
Route::get('/email/verify', [RegisterController::class, 'show']);
Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verify']);
//Route::post('/email/resend', [RegisterController::class, 'resend']);
Route::post('/reset_password', [RegisterController::class, 'resetPassword']);
Route::get('/reset_password', [RegisterController::class, 'resetPassword'])->name('password.reset');


// Route::post('refresh', 'AuthController@refresh');

Route::get('/email/verify/{id}', [RegisterController::class, 'verify'])
    ->name('email.verify')
    ->middleware('signed');


Route::get('mail', function () {

    $to_name = 'Bartosz Grabski';
    $to_email = 'grave432@gmail.com';
    $data = array('name' => "Sam Jose", "body" => "Test mail");

    Mail::send('welcome', $data, function ($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
            ->subject('Artisans Web Testing Mail');
        $message->from('rejestracja@roslina.com.pl', 'Artisans Web');
    });

    //Config::get('mail.from.name');

    return config('mail');;
    return env('MAIL_ENCRYPTION', 'tls');
});
