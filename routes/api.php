<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Book\BookController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Author\AuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Auth'], function () {

    // Login
    Route::post('login', [LoginController::class, 'login'])->name('login');
    // signup
    Route::post('signup', [LoginController::class, 'signup'])->name('signup');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    //Authors
    Route::group(['namespace' => 'Author', 'prefix' => 'authors'], function () {
        Route::get('/', [AuthorController::class, 'index'])->name('author.index');
        Route::get('/{id}/with-books', [AuthorController::class, 'getAuthorBooks'])->name('author.getAuthorBooks');
        Route::delete('/{id}', [AuthorController::class, 'destroy'])->name('author.destroy');
    });

    //Book
    Route::group(['namespace' => 'Book', 'prefix' => 'books'], function () {
        Route::post('/', [BookController::class, 'store'])->name('book.store');
        Route::delete('/{id}', [BookController::class, 'destroy'])->name('book.destroy');
    });
});
