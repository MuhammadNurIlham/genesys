<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route untuk menampilkan form register dan proses registrasi
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

// Route untuk menampilkan form login dan proses login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

// Route untuk proses logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/inventory', [InventoryController::class, "index"])->name('index');
Route::post('/selling/{id}', [InventoryController::class, "update"])->name('update');
Route::get('/selling', [InventoryController::class, "showFormSelling"])->name('selling');


Route::post('/buying', [InventoryController::class, "store"])->name('store');
Route::get('/buying', [InventoryController::class, "showFormBuying"])->name('buying');
Route::delete('/{id}', [InventoryController::class, "destroy"])->name('destroy');


// Route untuk CRUD inventaris
Route::resource('inventory', InventoryController::class);
