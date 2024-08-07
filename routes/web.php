<?php

use App\Exports\InvoiceExport;
use App\Http\Controllers\PDFController;
use App\Livewire\Erp\AvancementsPage;
use App\Livewire\Erp\BuildingPage;
use App\Livewire\Erp\BuildingsPage;
use App\Livewire\Erp\ClientsPage;
use App\Livewire\Erp\FinancesPage;
use App\Livewire\Erp\InvoicePage;
use App\Livewire\Erp\ProjetPage;
use App\Livewire\Erp\ProjetsPage;
use App\Livewire\Erp\RoomPage;
use App\Livewire\Erp\StagePage;
use App\Livewire\Erp\SystemesPage;
use App\Livewire\IndexPage;
use App\Livewire\JournalPage;
use App\Livewire\JournauxPage;
use App\Livewire\LoginPage;
use App\Livewire\Modules\ContactsPage;
use App\Livewire\ProfilePage;
use App\Livewire\SettingsPage;
use App\Livewire\Stock\AchatPage;
use App\Livewire\Stock\AchatsPage;
use App\Livewire\Stock\ArticlePage;
use App\Livewire\Stock\ArticlesPage;
use App\Livewire\Stock\BrandPage;
use App\Livewire\Stock\BrandsPage;
use App\Livewire\Stock\ProvidersPage;
use App\Livewire\Stock\StockPage;
use App\Livewire\Task\TaskPage;
use App\Livewire\Task\TasksPage;
use App\Livewire\TestPage;
use App\Livewire\UsersPage;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

// Index
Route::get('/', IndexPage::class)->name('index');

// Auth
Route::get('/login', LoginPage::class)->name('login');

// Settings
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', ProfilePage::class)->name('profile');
    Route::get('/settings', SettingsPage::class)->name('settings');
});

// ERP
Route::middleware(['auth', 'can:erp'])->group(function () {
    // Users
    // Route::get('/users', UsersPage::class)->name('users');

    // Clients
    Route::get('/clients', ClientsPage::class)->name('clients');
    // Projets
    Route::get('/projets/{client_id}', ProjetsPage::class)->name('projets');
    Route::get('/projet/{projet_id}', ProjetPage::class)->name('projet');
    // Devis
    Route::get('/invoice/{invoice_id}', InvoicePage::class)->name('invoice');
    Route::get('/facture/facture_pdf/{invoice_id}/{type}', function ($invoice_id, $type) { return PDFController::facture_pdf($invoice_id, $type); })->name('facture_pdf');
    Route::get('/facture/facture_acompte_pdf/{invoice_id}/{type}/{acompte_id?}', function ($invoice_id, $type, $acompte_id) { return PDFController::facture_acompte_pdf($invoice_id, $type, $acompte_id); })->name('facture_acompte_pdf');

    Route::get('invoice_export/{invoice_id}',  function ($invoice_id){ return Excel::download(new InvoiceExport($invoice_id), 'invoices.xlsx'); })->name('invoice_export');

    Route::post('invoice_import', 'InvoiceController@import')->name('invoice_import');

    // Journaux
    Route::get('/journal/{journal_id}', JournalPage::class)->name('journal');
    // Contacts
    Route::get('/contacts', ContactsPage::class)->name('contacts');
    // Taches
    Route::get('/tasks', TasksPage::class)->name('tasks');

    Route::get('/tasks_pdf/{id}/{type?}/{search?}/{status?}',  function ($id, $type='', $search='', $status=true) { return PDFController::tasks_pdf($id, $type, $search, $status); })->name('tasks_pdf');

    // Avancements
    Route::get('/avancements/{building_id}', AvancementsPage::class)->name('avancements');
    Route::get('/avancements_pdf/{avancement_id}', function ($avancement_id) {
        return PDFController::avancement_pdf($avancement_id);
    })->name('avancements_pdf');
});

// Stock
Route::middleware(['auth', 'can:stock'])->group(function () {
    Route::get('/stock', StockPage::class)->name('stock');
    Route::get('/stock/providers', ProvidersPage::class)->name('providers');
    Route::get('/stock/brands', BrandsPage::class)->name('brands');
    Route::get('/stock/brand/{brand_id}', BrandPage::class)->name('brand');
    Route::get('/stock/articles', ArticlesPage::class)->name('articles');
    Route::get('/stock/article/{article_id}', ArticlePage::class)->name('article');
    Route::get('/stock/achats', AchatsPage::class)->name('achats');
    Route::get('/stock/achat/{achat_id}', AchatPage::class)->name('achat');
    Route::get('/stock/achat_pdf/{achat_id}', function ($achat_id) {
        return PDFController::achat_pdf($achat_id);
    })->name('achat_pdf');
    Route::get('/stock/commande_pdf', function () {
        return PDFController::commande_pdf();
    })->name('commande_pdf');
});

// Building management

Route::middleware(['auth', 'can:erp'])->group(function () {
    Route::get('/buildings/{projet_id}', BuildingsPage::class)->name('buildings');
    Route::get('/building/{building_id}', BuildingPage::class)->name('building');
    Route::get('/stage/{stage_id}', StagePage::class)->name('stage');
    Route::get('/room/{room_id}', RoomPage::class)->name('room');
});

// Medias
Route::middleware(['auth','can:medias'])->group(function () {
    // Images
    // Route::get('/images', Image::class)->name('images');
    // Route::get('/image/{image_id}', TasksPage::class)->name('image');
    // Mangas
    // Route::get('/mangas', TasksPage::class)->name('mangas');
    // Route::get('/manga/{manga_id}', TasksPage::class)->name('manga');
    // Videos
    // Route::get('/videos', TasksPage::class)->name('videos');
    // Route::get('/video/{video_id}', TasksPage::class)->name('video');
});

// Tasks
Route::middleware(['auth', 'can:erp'])->group(function () {
    Route::get('/tasks', TasksPage::class)->name('tasks');
    Route::get('/task/{task_id}', TaskPage::class)->name('task');
});

// Journal
Route::middleware(['auth', 'can:erp'])->group(function () {
    // Route::get('/journaux', Journaux::class)->name('journaux');
    Route::get('/journaux', JournauxPage::class)->name('journaux');
    Route::get('/journaux/journal_pdf/{journal_id}', function ($journal_id) {
        return PDFController::journal_pdf($journal_id);
    })->name('journal_pdf');
});

// Finances
Route::middleware(['auth', 'can:finances'])->group(function () {
    Route::get('/finances', FinancesPage::class)->name('finances');

});

// Test
Route::get('/test', TestPage::class)->name('test');
Route::get('pdf_test', function () { return PDFController::pdf_test(); })->name('pdf_test');
Route::get('test_pdf', function () { return PDFController::test_pdf(); })->name('test_pdf');
Route::get('proces_verbal_pdf', function () { return PDFController::proces_verbal_pdf(); })->name('proces_verbal_pdf');
Route::get('doe_pdf', function () { return PDFController::proces_verbal_pdf(); })->name('doe_pdf');

Route::get('arp_card_pdf/{card_id}', function ($card_id) { return PDFController::arp_card_pdf($card_id); })->name('arp_card_pdf');
Route::get('arp_card_pdf2/{projet_id}', function ($projet_id) { return PDFController::arp_card_pdfs($projet_id); })->name('arp_card_pdfs');

// Test
Route::get('/systemes', SystemesPage::class)->name('systemes');
