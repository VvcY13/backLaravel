<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\productosController;
use App\Http\Controllers\QuejasyReclamosController;
use App\Http\Controllers\registroControler;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ventasController;
use Illuminate\Support\Facades\Route;


Route::post('/registrar', [registroControler::class, 'registrar']);
Route::post('/producto', [productosController::class, 'store']);
Route::get('/productos', [productosController::class, 'index']);
Route::post('/personal',[UserController::class, 'create']);
Route::get('/personal',[UserController::class, 'index']);
Route::put('/personal/{id}',[UserController::class, 'update']);
Route::delete('/personal/{id}',[UserController::class, 'destroy']);
Route::post('/login',[UserController::class,'login']);
Route::post('/logout', [UserController::class,'logout']);
Route::post('/carrito/agregar',[CarritoController::class,'addToCart']);
Route::get('/carrito',[CarritoController::class,'getCart']);
Route::post('/carrito/disminuirCantidad',[CarritoController::class,'disminuirCantidad']);
Route::post('/carrito/incrementarCantidad', [CarritoController::class, 'incrementarCantidad']);
Route::post('/carrito/removerProducto', [CarritoController::class, 'removerProducto']);
Route::post('/carrito/limpiar',[CarritoController::class, 'clearCart']);
Route::get('/perfil', [UserController::class, 'show']);
Route::put('/producto/{id}',[productosController::class, 'update']);
Route::delete('/producto/{id}',[productosController::class, 'destroy']);
Route::post('/checkout',[ventasController::class, 'create']);
Route::post('/quejasyreclamos', [QuejasyReclamosController::class, 'create']);
Route::get('/quejasyreclamos',[QuejasyReclamosController::class,'index']);
Route::get('/quejasyreclamos/{id_personal}', [QuejasyReclamosController::class, 'show']);
Route::get('/quejasyreclamosAsunto/{asunto}', [QuejasyReclamosController::class, 'showPorAsunto']);

Route::get('/user-sales', [VentasController::class, 'userSales'])->name('user.sales');
Route::get('/all-sales', [VentasController::class, 'index'])->name('all.sales');

Route::get('/', function () {
    return view('welcome');
});


