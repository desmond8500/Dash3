<?php

use App\Livewire\Erp\Clients;
use App\Livewire\IndexPage;
use App\Livewire\Pages\Index;
use App\Livewire\ProfilePage;
use App\Livewire\SettingsPage;
use App\Livewire\TestPage;
use Illuminate\Support\Facades\Route;

// Index
Route::get('/', IndexPage::class)->name('index');

// Settings
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', ProfilePage::class)->name('profile');
    Route::get('/settings', SettingsPage::class)->name('settings');
});

// ERP
Route::middleware(['auth'])->group(function () {
    Route::get('/clients', Clients::class)->name('clients');
});

// Test
Route::get('/test', TestPage::class)->name('test');
