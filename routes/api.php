<?php

use App\Http\Controllers\API\AchatController;
use App\Http\Controllers\API\BrandAPIController;
use App\Http\Controllers\API\ClientAPIController;
use App\Http\Controllers\API\FactureController;
use App\Http\Controllers\API\FavorisController;
use App\Http\Controllers\API\InvoiceAPIController;
use App\Http\Controllers\API\ItemsApiController;
use App\Http\Controllers\API\JournalAPIController;
use App\Http\Controllers\API\NoteAPIController;
use App\Http\Controllers\API\PersonaController;
use App\Http\Controllers\API\ProjetAPIController;
use App\Http\Controllers\API\ProviderAPIController;
use App\Http\Controllers\API\TaskAPIController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\LiensControlleur;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
| Seules la connexion et (si activée) l'inscription sont accessibles sans
| token. Tout le reste exige un token Sanctum : `Authorization: Bearer <token>`.
*/

Route::prefix('v1')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->middleware('throttle:6,1');

    if (config('auth.api_registration')) {
        Route::post('/register', [UserController::class, 'register'])->middleware('throttle:6,1');
    }
});

/*
|--------------------------------------------------------------------------
| Routes authentifiées
|--------------------------------------------------------------------------
| Les permissions reprennent celles des routes web (spatie/laravel-permission).
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn (Request $request) => $request->user());

    Route::prefix('v1')->group(function () {

        // Auth
        Route::get('/me', [UserController::class, 'me']);
        Route::post('/logout', [UserController::class, 'logout']);

        // Demo
        Route::get('demos', [DemoController::class, 'index'])->name('demos');

        // ERP : clients, projets, tâches, journaux, notes, liens, favoris
        Route::middleware('can:erp')->group(function () {
            Route::resource('clients', ClientAPIController::class);
            Route::get('clients_projets/{id}', [ClientAPIController::class, 'getProjets']);
            Route::get('clients_tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);

            Route::resource('projets', ProjetAPIController::class);
            Route::get('projet/tasks/{id}', [ProjetAPIController::class, 'getTasksByProjet']);

            // TODO : ces routes pointent toutes vers getTasksByClient, à implémenter.
            Route::get('invoice/tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);
            Route::get('building/tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);
            Route::get('stage/tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);
            Route::get('room/tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);

            Route::resource('journaux', JournalAPIController::class);
            Route::resource('projet_notes', NoteAPIController::class);
            Route::get('get_projet_notes/{projet_id}', [NoteAPIController::class, 'get_projet_notes']);

            Route::resource('tasks', TaskAPIController::class);
            Route::resource('liens', LiensControlleur::class);

            Route::get('favoris', [FavorisController::class, 'getFavoris'])->name('favoris');
        });

        // Stock : articles, fournisseurs, marques
        Route::middleware('can:stock')->group(function () {
            Route::apiResource('items', ItemsApiController::class);
            Route::get('items_image/{article_id}', [ItemsApiController::class, 'getImages']);
            Route::get('items_link/{article_id}', [ItemsApiController::class, 'getLinks']);
            Route::get('items_document/{article_id}', [ItemsApiController::class, 'getDocuments']);
            Route::apiResource('providers', ProviderAPIController::class);
            Route::apiResource('brands', BrandAPIController::class);
        });

        // Finances : devis, factures, achats, transactions
        Route::middleware('can:finances')->group(function () {
            Route::apiResource('invoices', InvoiceAPIController::class);
            Route::post('get_month_invoices', [InvoiceAPIController::class, 'get_month_invoices']);
            Route::post('get_month_deposit', [InvoiceAPIController::class, 'get_month_invoices_deposit']);
            Route::post('get_month_spents', [InvoiceAPIController::class, 'get_month_spents']);
            Route::post('paid_invoices', [InvoiceAPIController::class, 'paid_invoices']);
            Route::post('annual_paid_invoices', [InvoiceAPIController::class, 'annual_paid_invoices']);
            Route::post('get_annual_invoices_deposit', [InvoiceAPIController::class, 'get_annual_invoices_deposit']);

            Route::get('factures', [FactureController::class, 'get_factures']);
            Route::get('facture_pdf/{invoice_id}/{type}', function ($invoice_id, $type) {
                return PDFController::facture_pdf($invoice_id, $type);
            })->name('facture_pdf_api');

            Route::get('achats', [AchatController::class, 'get_achats']);
            Route::get('transactions', [TransactionController::class, 'get_transactions']);
        });

        // Médias
        Route::middleware('can:medias')->group(function () {
            Route::resource('personas', PersonaController::class);
        });
    });
});
