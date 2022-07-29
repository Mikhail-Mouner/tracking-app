<?php

use App\Http\Controllers\Api\{AuthenticationController, BabyController, PartnerController};
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
##############* Route:: Register & Login user *##############
Route::post('/create-account', [AuthenticationController::class, 'createAccount']);
Route::post('/signin', [AuthenticationController::class, 'signin']);

##############* Middleware (auth) *##############
Route::middleware('auth:sanctum')->group(function () {

    ##############* Route:: CRUD (Baby) *##############
    Route::apiResource('/baby', BabyController::class);

    ##############* Route:: Create & index (Partner) *##############
    Route::apiResource('/partner', PartnerController::class)->only('index', 'store');

    ##############* Route:: His Babies *##############
    Route::get('/parent/babies', [BabyController::class, 'myBaby']);

    ##############* Route:: Profile & Sign Out *##############
    Route::get('/me', [AuthenticationController::class, 'me']);
    Route::post('/sign-out', [AuthenticationController::class, 'signout']);

});

##############* Route:: Not Found Page *##############
Route::any('{path}', function () {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
})->where('path', '.*');
