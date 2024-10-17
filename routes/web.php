<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\Component\ClientComponentController;
use App\Http\Controllers\EntryCode\EntryCodeCreateController;
use App\Http\Controllers\EntryCode\EntryCodeEditController;
use App\Http\Controllers\EntryCode\EntryCodeListController;
use App\Http\Controllers\EntryCode\EntryCodeStoreController;
use App\Http\Controllers\EntryCode\EntryCodeUpdateController;
use App\Http\Controllers\GetCalendarDataController;
use App\Http\Controllers\GetDayReservationsController;
use App\Http\Controllers\People\PeopleController;
use App\Http\Controllers\People\PeoplelistController;
use App\Http\Controllers\PersonPermission\PersonPermissionController;
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

    Route::group(['prefix'=>'entry-code'],function(){

        Route::get('/list', [EntryCodeListController::class,'index'])->name('entry-codes-list');
        Route::get('/create',EntryCodeCreateController::class)->name('entry-codes-create');
        Route::post('/store', [EntryCodeStoreController::class,'store'])->name('entry-codes-store');
        Route::get('/edit/{id}',[EntryCodeEditController::class,'edit'])->name('entry-codes-edit');
        Route::put('/update/{id}',[EntryCodeUpdateController::class,'update'])->name('entry_codes-update');

    });
    Route::post('/change-status', [ChangeStatusController::class, 'change_status'])->name('change_status');
    Route::post('/change-person-permission-entry-code',[PersonPermissionController::class,'changeEntryCode']);

    Route::post('/client-component', [ClientComponentController::class, 'component'])->name('client.component');
    // =======Calendar=======================
    Route::get('/calendar/{id}',CalendarController::class)->name('calendar');
    Route::get('calendar-data/{id}', GetCalendarDataController::class);
    Route::get('get-day-reservations/{person}/{date}', GetDayReservationsController::class);

    // ========People==========================
    Route::resource('people', PeopleController::class);



});

Route::get('get-file', [FileUploadService::class, 'get_file'])->name('get-file');
