<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::controller(ActionController::class)->group(function () {
//     // Route::get('/', 'index')->name('reaction.index');
//     Route::post('/action', 'action')->name('reaction.action');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
