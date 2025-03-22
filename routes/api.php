<?php

use App\Http\Controllers\API\AchatController;
use App\Http\Controllers\api\BrandAPIController;
use App\Http\Controllers\API\FactureController;
use App\Http\Controllers\API\InvoiceAPIController;
use App\Http\Controllers\API\ItemsApiController;
use App\Http\Controllers\api\ProviderAPIController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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
// Articles
Route::prefix('v1')->group(function () {
    Route::apiResource('items', ItemsApiController::class);
    Route::resource('providers', ProviderAPIController::class);
    Route::resource('brands', BrandAPIController::class);
});

Route::prefix('v1')->group(function () {
    // Devis
    Route::apiResource('invoices', InvoiceAPIController::class);
    Route::post('get_month_invoices', [InvoiceAPIController::class, 'get_month_invoices']);
    Route::post('get_month_spents', [InvoiceAPIController::class, 'get_month_spents']);
    // Facture
    Route::get('factures', [FactureController::class, 'get_factures']);
    Route::get('facture_pdf/{invoice_id}/{type}', function ($invoice_id, $type) {
        return PDFController::facture_pdf($invoice_id, $type);
    })->name('facture_pdf_api');
    // Achats
    Route::get('achats', [AchatController::class, 'get_achats']);
    // Transaction
    Route::get('transactions', [TransactionController::class, 'get_transactions']);
    // Taches
    Route::resource('tasks', TaskController::class);
});


