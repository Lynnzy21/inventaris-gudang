<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

// Route sementara untuk melihat layout (akan dipindah ke controller di Fase 4)
Route::get('/dashboard', function () {
    return view('dashboard.index');
});