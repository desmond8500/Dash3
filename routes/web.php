<?php

use App\Livewire\Erp\Clients;
use Illuminate\Support\Facades\Route;

Route::get('/', Clients::class)->name('index');
