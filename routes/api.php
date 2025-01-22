<?php

use App\Http\Controllers\api\BrandAPIController;
use App\Http\Controllers\API\ItemsApiController;
use App\Http\Controllers\api\ProviderAPIController;
use App\Http\Controllers\DemoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Auth
    // Route::get('sign_in', 'UserController@sign_in')->name('sign_in');
    // Route::get('sign_out', 'UserController@sign_out')->name('sign_out');
    // Route::get('register', 'UserController@register')->name('register');
    // Route::get('edit_password', 'UserController@edit_password')->name('edit_password');

    // Users
    // Route::get('users', 'UserController@users')->name('users');
    // Route::post('user_add', 'UserController@user_add')->name('user_add');
    // Route::post('user_update', 'UserController@user_update')->name('user_update');
    // Route::post('user_delete', 'UserController@user_delete')->name('user_delete');

});

// Demo
Route::get('demos', [DemoController::class, 'index'])->name('demos');
Route::apiResource('v1/items', ItemsApiController::class);
Route::resource('v1/providers', ProviderAPIController::class);
Route::resource('v1/brands', BrandAPIController::class);

