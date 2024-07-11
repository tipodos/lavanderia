<?php

use App\Http\Controllers\ListaController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/producto', [ProductoController::class,'index'])->name('producto.index');
Route::post('/producto/store', [ProductoController::class,'store'])->name('producto.store');
Route::get('/producto/edit/{id}', [ProductoController::class,'edit'])->name('producto.edit');
Route::PUT('/producto/update/{id}',[ProductoController::class,'update'])->name('producto.update');
Route::delete('/producto/delete/{id}', [ProductoController::class,'delete'])->name('producto.delete');


Route::get('/', [PersonalController::class,'index'])->name('index');
Route::post('/store', [PersonalController::class,'store'])->name('store');
Route::get('/show/{id}', [PersonalController::class,'show'])->name('show');
Route::PUT('/update/{id}',[PersonalController::class,'update'])->name('update');
Route::delete('/delete/{id}', [PersonalController::class,'delete'])->name('delete');

Route::get('/lista', [ListaController::class,'index'])->name('lista.index');
Route::get('orders/export', [ListaController::class, 'export'])->name('orders.export');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
