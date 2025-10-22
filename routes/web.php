<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\AsignaturaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta raíz (pública)
Route::get('/', function () {
    return view('inicio');
})->name('home');

// Ruta de login (temporal - placeholder)
Route::get('/login', function () {
    return view('inicio');
})->name('login');

// Rutas protegidas (requieren autenticación)
Route::get('/asignaturas/{grade}/{student_id}', [AsignaturaController::class, 'listarAsignaturas']);
Route::get('/asignatura/{asignatura}', [AsignaturaController::class, 'detalleAsignatura']);
Route::get('/estudiantes', [EstudiantesController::class, 'listarEstudiantes']);