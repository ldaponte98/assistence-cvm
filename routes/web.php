<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ConectionGroupController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;

Route::get('/test', function () { return view('site.test'); });
Route::get('/', function () { return view('site.login'); });
Route::group(['prefix' => 'panel'], function () {
	Route::any('', [PanelController::class, 'index'])->name('panel');
});
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
	Route::get('find-by-characters/{characters}/{type?}', [PeopleController::class, 'findByCharacters'])->name('people/find-by-characters');
	Route::get('find-by-phone/{phone}', [PeopleController::class, 'findByPhone'])->name('people/find-by-phone');
	Route::put('update', [PeopleController::class, 'update'])->name('people/update');
	Route::post('create', [PeopleController::class, 'create'])->name('people/create');
});

Route::group(['prefix' => 'conection-group'], function () {
	Route::get('all', [ConectionGroupController::class, 'all'])->name('conection-group/all');
	Route::get('settings/{id?}', [ConectionGroupController::class, 'settings'])->name('conection-group/settings');
	Route::put('update', [ConectionGroupController::class, 'update'])->name('conection-group/update');
	Route::post('create', [ConectionGroupController::class, 'create'])->name('conection-group/create');
	Route::get('find-by-red/{red}', [ConectionGroupController::class, 'findByRed'])->name('conection-group/find-by-red');
	Route::get('me-group', [ConectionGroupController::class, 'meGroup'])->name('conection-group/me-group');
	Route::delete('remove-people/{people_id}/{conection_group_id}', [ConectionGroupController::class, 'removePeople'])->name('conection-group/remove-people');
});

Route::group(['prefix' => 'event'], function () {
	Route::any('all', function () { return view('event.calendar.calendar'); })->name('event/all');
	Route::get('find', [EventController::class, 'find'])->name('event/find');
	Route::put('update', [EventController::class, 'update'])->name('event/update');
	Route::post('create', [EventController::class, 'create'])->name('event/create');
	Route::put('cancel/{id}', [EventController::class, 'cancel'])->name('event/cancel');
	Route::get('settings/{id}', [EventController::class, 'settings'])->name('event/settings');
	Route::post('save-assistance', [EventController::class, 'saveAssistance'])->name('event/save-assistance');	
	Route::get('find-assistants/{event_id}', [EventController::class, 'findAssistants'])->name('event/find-assistants');
});

Route::group(['prefix' => 'report'], function () {
	Route::view('assistance-general', 'report.assistance.assistance-general');
	Route::post('get-assistance-general', [ReportController::class, 'getAssistanceGeneral'])->name('report/get-assistance-general');
});

