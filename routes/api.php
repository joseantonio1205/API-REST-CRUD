<?php

use App\Http\Controllers\studentsController;
use Illuminate\Support\Facades\Route;

Route::get('/estudiante', [studentsController::class, 'index']);

Route::get('/estudiante/obt/{id}', [studentsController::class, 'show']);

Route::POST('/estudiante/create', [studentsController::class, 'store']);

Route::put('/estudiante/update/{id}', [studentsController::class, 'update']);

Route::patch('/estudiante/update/dato/{id}', [studentsController::class, 'update_patch']);

Route::delete('/estudiante/delete/{id}', [studentsController::class, 'destroy']);

