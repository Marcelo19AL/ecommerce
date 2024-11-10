<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']); // Listar productos
    Route::get('/{id}', [ProductController::class, 'show']); // Detalles de un producto específico
    Route::post('/', [ProductController::class, 'store'])->middleware('auth:api'); // Crear un nuevo producto (solo admin)
    Route::put('/{id}', [ProductController::class, 'update'])->middleware('auth:api'); // Actualizar un producto (solo admin)
    Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware('auth:api'); // Eliminar un producto (solo admin)
});

// Rutas para Órdenes
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->middleware('auth:api'); // Listar órdenes del usuario autenticado
    Route::get('/{id}', [OrderController::class, 'show'])->middleware('auth:api'); // Ver detalles de una orden específica
    Route::post('/', [OrderController::class, 'store'])->middleware('auth:api'); // Crear una nueva orden
    Route::put('/{id}', [OrderController::class, 'update'])->middleware('auth:api'); // Actualizar una orden (opcional)
    Route::delete('/{id}', [OrderController::class, 'destroy'])->middleware('auth:api'); // Cancelar una orden
});

// Rutas para Carrito de Compras
Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->middleware('auth:api'); // Agregar producto al carrito
    Route::post('/remove', [CartController::class, 'remove'])->middleware('auth:api'); // Eliminar producto del carrito
    Route::get('/', [CartController::class, 'index'])->middleware('auth:api'); // Ver el carrito del usuario
});
