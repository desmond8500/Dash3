<?php

use App\Livewire\Erp\Clients;
use App\Livewire\Pages\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('index');
Route::get('/clients', Clients::class)->name('clients');
