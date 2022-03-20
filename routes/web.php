<?php

use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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



/**
 * Grupo de rotas protegidas por acesso
 * 
 */
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    
    Route::get('/', function () {
        return Inertia::render('Welcome');
    })->name('home');

    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Welcome');
    })->name('dashboard');
        
    // Manage Articles
    Route::get('/article', function () {
        return Inertia::render('Article');
    })->name('article');

    // Simulate Order
    Route::get('/order', function () {
        return Inertia::render('Order');
    })->name('order');
    

});