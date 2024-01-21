<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () { return view('site.login'); });
Route::any('panel', function () { return view('site.panel'); })->name('panel');

Route::group(['prefix' => 'user'], function () {
	Route::post('login', [UserController::class, 'login']);
	Route::any('logout', [UserController::class, 'logout'])->name('logout');
	Route::get('all', [UserController::class, 'all'])->name('user/all');
	Route::get('/{id}', [UserController::class, 'get'])->name('user/get');
	Route::any('update/{id}', [UserController::class, 'update'])->name('user/update');
	Route::any('create', [UserController::class, 'create'])->name('user/create');
});