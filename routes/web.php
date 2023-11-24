<?php

use App\Livewire\Erp\ClientsPage;
use App\Livewire\Erp\ProjetPage;
use App\Livewire\Erp\ProjetsPage;
use App\Livewire\IndexPage;
use App\Livewire\LoginPage;
use App\Livewire\ProfilePage;
use App\Livewire\SettingsPage;
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
    // Route::get('/devis/{devis_id}', Devis::class)->name('devis');
    // Route::get('/journaux/{projet_id}', Journaux::class)->name('journaux');
});

// Stock

// Medias

// Tasks

// Test
Route::get('/test', TestPage::class)->name('test');
