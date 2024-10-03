<?php

use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(ActionController::class)->group(function () {
    // Route::get('/', 'index')->name('reaction.index');
    Route::post('/action', 'action')->name('reaction.action');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
