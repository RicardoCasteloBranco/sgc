<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/centro', \App\Livewire\CentroEnsino::class)->name('centro-ensino');
    Route::get('/supervisor', \App\Livewire\Supervisor::class)->name('supervisor');
    Route::get('/curso', \App\Livewire\CursosTable::class)->name('curso');
});
