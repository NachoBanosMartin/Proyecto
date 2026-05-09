<?php

use App\Http\Controllers\AdminComentarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminEstadisticaController;
use App\Http\Controllers\AdminLocalizacionController;
use App\Http\Controllers\AdminProduccionController;
use App\Http\Controllers\AdminRelacionController;
use App\Http\Controllers\AdminUsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\LocalizacionController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PerfilController;

// Página principal

Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Acceso y registro de usuarios

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.autenticar');

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro'])->name('registro.guardar');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Consulta pública de producciones y localizaciones

Route::get('/producciones/{tipo}', [ProduccionController::class, 'index'])->name('producciones.index');
Route::get('/localizacion/{idProduccion}/{idLocalizacion}', [LocalizacionController::class, 'show'])->name('localizacion.show');

// Funciones disponibles para usuarios registrados

Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
Route::post('/favoritos/toggle/{idLocalizacion}', [FavoritoController::class, 'toggle'])->name('favoritos.toggle');

Route::post('/comentarios/guardar', [ComentarioController::class, 'guardar'])->name('comentarios.guardar');

Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
Route::put('/perfil/actualizar', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
Route::delete('/perfil/eliminar', [PerfilController::class, 'eliminar'])->name('perfil.eliminar');

// Panel de administrador

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Gestión de producciones

Route::get('/admin/producciones', [AdminProduccionController::class, 'index'])->name('admin.producciones');
Route::post('/admin/producciones', [AdminProduccionController::class, 'guardar'])->name('admin.producciones.guardar');
Route::get('/admin/producciones/{idProduccion}/editar', [AdminProduccionController::class, 'editar'])->name('admin.producciones.editar');
Route::put('/admin/producciones/{idProduccion}', [AdminProduccionController::class, 'actualizar'])->name('admin.producciones.actualizar');
Route::delete('/admin/producciones/{idProduccion}', [AdminProduccionController::class, 'eliminar'])->name('admin.producciones.eliminar');

// Gestión de localizaciones

Route::get('/admin/localizaciones', [AdminLocalizacionController::class, 'index'])->name('admin.localizaciones');
Route::post('/admin/localizaciones', [AdminLocalizacionController::class, 'guardar'])->name('admin.localizaciones.guardar');
Route::get('/admin/localizaciones/{idLocalizacion}/editar', [AdminLocalizacionController::class, 'editar'])->name('admin.localizaciones.editar');
Route::put('/admin/localizaciones/{idLocalizacion}', [AdminLocalizacionController::class, 'actualizar'])->name('admin.localizaciones.actualizar');
Route::delete('/admin/localizaciones/{idLocalizacion}', [AdminLocalizacionController::class, 'eliminar'])->name('admin.localizaciones.eliminar');

// Relaciones entre producciones y localizaciones

Route::get('/admin/relaciones', [AdminRelacionController::class, 'index'])->name('admin.relaciones');
Route::post('/admin/relaciones', [AdminRelacionController::class, 'guardar'])->name('admin.relaciones.guardar');
Route::delete('/admin/relaciones/{idProduccionLocalizacion}', [AdminRelacionController::class, 'eliminar'])->name('admin.relaciones.eliminar');

// Moderación de comentarios

Route::get('/admin/comentarios', [AdminComentarioController::class, 'index'])->name('admin.comentarios');
Route::delete('/admin/comentarios/{idComentario}', [AdminComentarioController::class, 'eliminar'])->name('admin.comentarios.eliminar');

// Gestión de usuarios y estadisticas

Route::get('/admin/usuarios', [AdminUsuarioController::class, 'index'])->name('admin.usuarios');
Route::put('/admin/usuarios/{idUsuario}', [AdminUsuarioController::class, 'actualizar'])->name('admin.usuarios.actualizar');
Route::delete('/admin/usuarios/{idUsuario}', [AdminUsuarioController::class, 'eliminar'])->name('admin.usuarios.eliminar');
Route::get('/admin/estadisticas', [AdminEstadisticaController::class, 'index'])->name('admin.estadisticas');