<?php

use App\Livewire\Erp\Clients;
use App\Livewire\IndexPage;
use App\Livewire\LoginPage;
use App\Livewire\Pages\Index;
use App\Livewire\RegisterPage;
use App\Livewire\TestPage;
use Illuminate\Support\Facades\Route;

// Index
Route::get('/', IndexPage::class)->name('index');
// Auth
// Route::get('/loginPage', LoginPage::class)->name('loginPage');
// Route::get('/registerPage', RegisterPage::class)->name('registerPage');
// ERP
// Test
Route::get('/test', TestPage::class)->name('test');
