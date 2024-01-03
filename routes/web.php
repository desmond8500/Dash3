<?php

use App\Livewire\Erp\ClientsPage;
use App\Livewire\Erp\InvoicePage;
use App\Livewire\Erp\Journaux;
use App\Livewire\Erp\ProjetPage;
use App\Livewire\Erp\ProjetsPage;
use App\Livewire\IndexPage;
use App\Livewire\LoginPage;
use App\Livewire\ProfilePage;
use App\Livewire\SettingsPage;
use App\Livewire\Stock\AchatPage;
use App\Livewire\Stock\AchatsPage;
use App\Livewire\Stock\ArticlePage;
use App\Livewire\Stock\ArticlesPage;
use App\Livewire\Stock\BrandsPage;
use App\Livewire\Stock\ProvidersPage;
use App\Livewire\Stock\StockPage;
use App\Livewire\TestPage;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/clients', ClientsPage::class)->name('clients');
    Route::get('/projets/{client_id}', ProjetsPage::class)->name('projets');
    Route::get('/projet/{projet_id}', ProjetPage::class)->name('projet');
    Route::get('/invoice/{invoice_id}', InvoicePage::class)->name('invoice');
    // Route::get('/journaux/{projet_id}', Journaux::class)->name('journaux');
});

// Stock
Route::middleware(['auth'])->group(function () {
    Route::get('/stock', StockPage::class)->name('stock');
    Route::get('/stock/providers', ProvidersPage::class)->name('providers');
    Route::get('/stock/brands', BrandsPage::class)->name('brands');
    Route::get('/stock/articles', ArticlesPage::class)->name('articles');
    Route::get('/stock/article/{article_id}', ArticlePage::class)->name('article');
    Route::get('/stock/achat', AchatPage::class)->name('achat');
    Route::get('/stock/achats', AchatsPage::class)->name('achats');
});

// Medias

// Tasks

// Journal
Route::middleware(['auth'])->group(function () {
    Route::get('/journaux', Journaux::class)->name('journaux');
});

// Test
Route::get('/test', TestPage::class)->name('test');
