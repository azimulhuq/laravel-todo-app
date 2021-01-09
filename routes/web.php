<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::prefix('/tasks')->group(function () {
    Route::get('/', [TaskController::class, 'list'])
        ->name('tasks.all');
    Route::get('/create', [TaskController::class, 'create'])
        ->name('task.create');
    Route::post('/create', [TaskController::class, 'save'])
        ->name('task.save');
    Route::get('/{id}/edit', [TaskController::class, 'edit'])
        ->name('task.edit');
    Route::post('/{id}', [TaskController::class, 'update'])
        ->name('task.update');
    Route::post('/{id}/complete', [TaskController::class, 'complete'])
        ->name('task.complete');
    Route::post('/{id}/pending', [TaskController::class, 'pending'])
        ->name('task.pending');
    Route::post('/{id}/delete', [TaskController::class, 'delete'])
        ->name('task.delete');
});
