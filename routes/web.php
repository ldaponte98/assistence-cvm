<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeopleController;

Route::get('/', function () { return view('site.login'); });
Route::any('panel', function () { return view('site.panel'); })->name('panel');

Route::group(['prefix' => 'user'], function () {
	Route::post('login', [UserController::class, 'login']);
	Route::any('logout', [UserController::class, 'logout'])->name('logout');
	Route::get('all', [UserController::class, 'all'])->name('user/all');
	Route::put('change-status/{id}/{status}', [UserController::class, 'changeStatus'])->name('user/change-status');
	Route::put('update', [UserController::class, 'update'])->name('user/update');
	Route::post('create', [UserController::class, 'create'])->name('user/create');
});

Route::group(['prefix' => 'people'], function () {
	Route::get('all', [PeopleController::class, 'all'])->name('people/all');
	Route::get('find-by-characters/{characters}', [PeopleController::class, 'findByCharacters'])->name('people/find-by-characters');
	Route::put('update', [PeopleController::class, 'update'])->name('people/update');
	Route::post('create', [PeopleController::class, 'create'])->name('people/create');
});

Route::group(['prefix' => 'event'], function () {
	Route::any('all', function () { return view('event.calendar.calendar'); })->name('event/all');
});