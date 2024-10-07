<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\People\PeopleCreateController;
use App\Http\Controllers\People\PeopleStoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Services\FileUploadService;
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

    Route::get('/create',PeopleCreateController::class)->name('people-create');
    Route::post('/store', [PeopleStoreController::class,'store'])->name('people-store');


});
Route::get('get-file', [FileUploadService::class, 'get_file'])->name('get-file');

