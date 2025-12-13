<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

// CRUD Buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');

Route::get('/buku/{id_buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{id_buku}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id_buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::get('/buku/cetak/pdf', [BukuController::class, 'cetakPDF'])->name('buku.cetak.pdf');
