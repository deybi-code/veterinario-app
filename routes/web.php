<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VeterinarioController;
use App\Http\Controllers\AtencionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Redireccionamos la raíz directamente a Atenciones para que cargue tu examen de frente
Route::get('/', function () {
    return redirect()->route('atenciones.index');
});

// Rutas del CRUD del Examen (Abiertas para facilitar tu evaluación)
Route::resource('veterinarios', VeterinarioController::class)->except(['create', 'edit', 'show']);
Route::resource('atenciones', AtencionController::class)->except(['create', 'edit', 'show']);

// Rutas por defecto de Breeze (las dejamos por si las necesitas)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';