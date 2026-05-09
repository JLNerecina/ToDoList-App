<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/deleted', [TaskController::class, 'deleted'])->name('tasks.deleted');
    Route::post('/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::delete('/{id}/force', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');
    Route::get('/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::get('/status/{status}', [TaskController::class, 'getByStatus'])->name('tasks.byStatus');
});