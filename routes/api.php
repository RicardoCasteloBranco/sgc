<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/turmas', '\App\Http\Controllers\Api\DashboardController@turmas');
Route::get('/cursos', '\App\Http\Controllers\Api\DashboardController@cursos');
Route::get('/alunos', '\App\Http\Controllers\Api\DashboardController@alunos');