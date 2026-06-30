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
    Route::get('/dashboard', \App\Livewire\DashboardComponent::class)->name('dashboard');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::get('/centro', \App\Livewire\CentroEnsino::class)->name('centro-ensino');
    Route::get('/supervisor', \App\Livewire\Supervisor::class)->name('supervisor');
    Route::get('/curso', \App\Livewire\CursosTable::class)->name('curso');
    Route::get('/projetos/{projeto}', \App\Livewire\ProjetoDetail::class);
    Route::get('/parecer/{id}/visualizar', [\App\Http\Controllers\ParecerTecnicoController::class, 'visualizar'])->name('parecer.visualizar');
    Route::get('/calendario', \App\Livewire\CalendarioCursos::class)->name('calendario');
    Route::get('/turma/{turma}', \App\Livewire\TurmaDetail::class)->name('turma');
    Route::get('/cadastro_material', \App\Livewire\CadastroMaterialBelico::class)->name('cadastro');
    Route::get('/perfil',\App\Livewire\PerfilComponent::class)->name('perfil');
});
