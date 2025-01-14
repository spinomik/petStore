<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update');

Route::get('/pets/search', [PetController::class, 'search'])->name('pets.search');

Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');

Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');
