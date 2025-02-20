<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeopleController;

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

Route::middleware(['validate.token.application'])->group(function () {
    Route::get('user/identity', [UserController::class, 'identity']);
    Route::get('people/find-by-document/{document}', [PeopleController::class, 'findByDocument']);
    Route::get('people/find-by-phone/{document}', [PeopleController::class, 'findByPhone']);
    Route::post('people', [PeopleController::class, 'createExternal']);
});