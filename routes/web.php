<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportIfixitController;
use App\Http\Controllers\GuideController;

// Ruta principal (lista de guías)
Route::get('/', [GuideController::class, 'index'])->name('home');

// Ruta para importar guías desde iFixit (ImportIfixitController)
Route::get('/import-ifixit', ImportIfixitController::class);

// Rutas para las vistas de guías (GuideController)
Route::get('/guides', [GuideController::class, 'index'])->name('guides.index'); // Lista de guías
Route::get('/guides/{guide}', [GuideController::class, 'show'])->name('guides.show'); // Detalle de una guía

// Rutas adicionales (opcional)
// Route::get('/guides/search', [GuideController::class, 'search'])->name('guides.search'); // Búsqueda de guías
// Route::get('/guides/category/{category}', [GuideController::class, 'category'])->name('guides.category'); // Guías por categoría
