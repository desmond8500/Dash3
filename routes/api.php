<?php

use App\Http\Controllers\API\AchatController;
use App\Http\Controllers\API\BrandAPIController;
use App\Http\Controllers\API\ClientAPIController;
use App\Http\Controllers\API\FactureController;
use App\Http\Controllers\API\FavorisController;
use App\Http\Controllers\API\InstallationAPIController;
use App\Http\Controllers\API\InvoiceAPIController;
use App\Http\Controllers\API\InvoiceEditAPIController;
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
            Route::post('clients/{id}/favorite', [ClientAPIController::class, 'toggleFavorite']);
            Route::post('clients/{id}/avatar', [ClientAPIController::class, 'updateAvatar']);
            Route::get('clients/{id}/contacts', [ClientAPIController::class, 'getContacts']);

            Route::resource('projets', ProjetAPIController::class);
            Route::get('projet/tasks/{id}', [ProjetAPIController::class, 'getTasksByProjet']);
            Route::post('projets/{id}/favorite', [ProjetAPIController::class, 'toggleFavorite']);
            Route::post('projets/{id}/logo', [ProjetAPIController::class, 'updateLogo']);
            Route::get('projets/{id}/badges', [ProjetAPIController::class, 'getBadges']);

            // Installations : bâtiments › systèmes › équipements, et plans
            Route::get('projets/{id}/installations', [InstallationAPIController::class, 'index']);
            Route::post('buildings', [InstallationAPIController::class, 'storeBuilding']);
            Route::put('buildings/{id}', [InstallationAPIController::class, 'updateBuilding']);
            Route::delete('buildings/{id}', [InstallationAPIController::class, 'destroyBuilding']);
            Route::post('installation_systemes', [InstallationAPIController::class, 'storeSysteme']);
            Route::put('installation_systemes/{id}', [InstallationAPIController::class, 'updateSysteme']);
            Route::delete('installation_systemes/{id}', [InstallationAPIController::class, 'destroySysteme']);
            Route::post('equipements', [InstallationAPIController::class, 'storeEquipement']);
            Route::put('equipements/{id}', [InstallationAPIController::class, 'updateEquipement']);
            Route::delete('equipements/{id}', [InstallationAPIController::class, 'destroyEquipement']);
            Route::get('projets/{id}/plans', [InstallationAPIController::class, 'plans']);
            Route::post('plans', [InstallationAPIController::class, 'storePlan']);
            Route::put('plans/{id}', [InstallationAPIController::class, 'updatePlan']);
            Route::delete('plans/{id}', [InstallationAPIController::class, 'destroyPlan']);
            Route::get('plans/{id}/markers', [InstallationAPIController::class, 'markers']);
            Route::put('plans/{id}/markers', [InstallationAPIController::class, 'saveMarkers']);
            Route::get('plans/{id}/file', [InstallationAPIController::class, 'file']);
            Route::post('plans/{id}/convert', [InstallationAPIController::class, 'convert']);

            // TODO : ces routes pointent toutes vers getTasksByClient, à implémenter.
            Route::get('invoice/tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);
            Route::get('building/tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);
            Route::get('stage/tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);
            Route::get('room/tasks/{id}', [ClientAPIController::class, 'getTasksByClient']);

            Route::resource('journaux', JournalAPIController::class);
            Route::resource('projet_notes', NoteAPIController::class);
            Route::get('get_projet_notes/{projet_id}', [NoteAPIController::class, 'get_projet_notes']);

            Route::post('tasks/{id}/statut', [TaskAPIController::class, 'setStatut']);
            Route::resource('tasks', TaskAPIController::class);
            Route::resource('liens', LiensControlleur::class);

            Route::get('favoris', [FavorisController::class, 'getFavoris'])->name('favoris');
        });

        // Stock : articles, fournisseurs, marques
        Route::middleware('can:stock')->group(function () {
            Route::get('items_types', [ItemsApiController::class, 'getTypes']);
            Route::post('items/{id}/quantity', [ItemsApiController::class, 'adjustQuantity']);
            Route::post('items/{id}/tags', [ItemsApiController::class, 'attachTag']);
            Route::delete('items/{id}/tags', [ItemsApiController::class, 'detachTag']);
            Route::post('items/{id}/images', [ItemsApiController::class, 'storeImages']);
            Route::post('items/{id}/image-default', [ItemsApiController::class, 'setDefaultImage']);
            Route::delete('items/{id}/images', [ItemsApiController::class, 'deleteImage']);
            Route::get('items/{id}/dependances', [ItemsApiController::class, 'getDependances']);
            Route::post('items/{id}/dependances', [ItemsApiController::class, 'addDependance']);
            Route::post('dependances/{id}/quantity', [ItemsApiController::class, 'adjustDependance']);
            Route::delete('dependances/{id}', [ItemsApiController::class, 'removeDependance']);
            Route::post('items/{id}/commande', [ItemsApiController::class, 'commander']);
            Route::apiResource('items', ItemsApiController::class);
            Route::get('items_image/{article_id}', [ItemsApiController::class, 'getImages']);
            Route::get('items_link/{article_id}', [ItemsApiController::class, 'getLinks']);
            Route::get('items_document/{article_id}', [ItemsApiController::class, 'getDocuments']);
            Route::apiResource('providers', ProviderAPIController::class);
            Route::apiResource('brands', BrandAPIController::class);
            Route::post('providers/{id}/logo', [ProviderAPIController::class, 'updateLogo']);
            Route::post('brands/{id}/logo', [BrandAPIController::class, 'updateLogo']);
        });

        // Finances : devis, factures, achats, transactions
        Route::middleware('can:finances')->group(function () {
            Route::apiResource('invoices', InvoiceAPIController::class);
            Route::post('invoices/{id}/favorite', [InvoiceAPIController::class, 'toggleFavorite']);
            // Édition du devis : sections, lignes, acomptes, dépenses
            Route::post('invoice_sections', [InvoiceEditAPIController::class, 'storeSection']);
            Route::put('invoice_sections/{id}', [InvoiceEditAPIController::class, 'updateSection']);
            Route::delete('invoice_sections/{id}', [InvoiceEditAPIController::class, 'destroySection']);
            Route::post('invoice_sections/{id}/duplicate', [InvoiceEditAPIController::class, 'duplicateSection']);
            Route::post('invoice_rows', [InvoiceEditAPIController::class, 'storeRow']);
            Route::put('invoice_rows/{id}', [InvoiceEditAPIController::class, 'updateRow']);
            Route::delete('invoice_rows/{id}', [InvoiceEditAPIController::class, 'destroyRow']);
            Route::post('invoice_acomptes', [InvoiceEditAPIController::class, 'storeAcompte']);
            Route::delete('invoice_acomptes/{id}', [InvoiceEditAPIController::class, 'destroyAcompte']);
            Route::post('invoice_spents', [InvoiceEditAPIController::class, 'storeSpent']);
            Route::delete('invoice_spents/{id}', [InvoiceEditAPIController::class, 'destroySpent']);
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
