<?php

use App\Http\Controllers\Api\ConfirmationCodeController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Api\OlympiadController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TelegramChannelController;
use App\Http\Middleware\LocalizeApiRequest;
use App\Http\Middleware\VerifyAccessToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(VerifyAccessToken::class)->prefix('v1')->group(function () {

    Route::prefix('students')->controller(StudentController::class)->group(function () {
        Route::get('/{chatId}', 'find')->whereNumber('chatId');
        Route::put('/create', 'create');
    });

    Route::get('/channels', [TelegramChannelController::class, 'get']);

    Route::get('/regions', [RegionController::class, 'get']);

    Route::get('/districts', [DistrictController::class, 'get']);

    Route::get('/institutions', [InstitutionController::class, 'get']);

    Route::middleware(LocalizeApiRequest::class)->group(function () {
        Route::prefix('code')->controller(ConfirmationCodeController::class)->group(function () {
            Route::post('/send', 'send');
            Route::post('/verify', 'verify');
        });

        Route::prefix('olympiad')->controller(OlympiadController::class)->group(function () {
            Route::put('/sign-up', 'signUp');
            Route::put('/start', 'start');
            Route::get("/{olympiad_id}/student/{student_id}/question/{number}", 'getQuestion');
            Route::put('/answer', 'registerAnswer');
        });
    });
});
