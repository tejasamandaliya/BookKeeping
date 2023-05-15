<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Author\AuthorController;
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


Route::get('/login', [LoginController::class, 'getLogin'])->name('get.login');
Route::post('/login', [LoginController::class, 'postLogin'])->name("post.login");

// Authors
Route::get('/authors', [AuthorController::class, 'index'])->name("get.authors");
Route::get('/authors/{id}', [AuthorController::class, 'show'])->name("show.authors");

// Books
Route::get('/books', [BookController::class, 'index'])->name("get.books");

// Logout
Route::get('/logout', [LoginController::class, 'logout'])->name("logout");
