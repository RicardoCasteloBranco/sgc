<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/turmas', '\App\Http\Controllers\Api\DashboardController@turmas');
Route::get('/alunos', '\App\Http\Controllers\Api\DashboardController@alunos');
Route::get('/projetos', '\App\Http\Controllers\Api\DashboardController@projetos');
Route::get('/cursos_em_andamento', '\App\Http\Controllers\Api\CursoController@cursosEmAndamento');