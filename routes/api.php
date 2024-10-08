<?php

use App\Http\Controllers\Api\Turnstile\CheckQRController;
use App\Http\Controllers\Api\Turnstile\EntryCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



// ======================== turnstile Турникет ======================================
Route::group(['prefix' => 'turnstile'], function ($router) {

    Route::post('entry-code/store', [EntryCodeController::class, 'store']);
    Route::post('entry-code/test', [EntryCodeController::class, 'test']);


    // Route::post('check-qr', CheckQRController::class);
    // Route::post('active-qrs', ActiveQrsController::class);
    // Route::post('qr-black-list', QrBlackListController::class);

});
