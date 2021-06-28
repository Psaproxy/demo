<?php
/** @noinspection DuplicatedCode */

use App\Http\Controllers\BooksCatalog\BookAuthorController;
use App\Http\Controllers\BooksCatalog\BookController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    /**
     * Dashboard
     */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /**
     * Books authors
     */
    Route::prefix('/books-authors')->name('books-authors.')->group(function () {
        Route::get('/', [BookAuthorController::class, 'list'])->name('list');
        Route::get('/add', [BookAuthorController::class, 'adding'])->name('adding');
        Route::post('/add', [BookAuthorController::class, 'add'])->name('add');
        Route::get('/{id}', [BookAuthorController::class, 'editing'])->name('editing');
        Route::patch('/update', [BookAuthorController::class, 'update'])->name('update');
        Route::delete('/delete', [BookAuthorController::class, 'delete'])->name('delete');
    });

    /**
     * Books
     */
    Route::prefix('/books')->name('books.')->group(function () {
        Route::get('/', [BookController::class, 'list'])->name('list');
        Route::get('/add', [BookController::class, 'adding'])->name('adding');
        Route::post('/add', [BookController::class, 'add'])->name('add');
        Route::get('/{id}', [BookController::class, 'editing'])->name('editing');
        Route::patch('/update', [BookController::class, 'update'])->name('update');
        Route::delete('/delete', [BookController::class, 'delete'])->name('delete');
    });
});