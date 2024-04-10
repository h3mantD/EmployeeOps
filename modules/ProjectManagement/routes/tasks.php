<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\ProjectManagement\Http\Controllers\TaskController;

Route::group([
    'middleware' => ['auth:web,employee'],
], function (): void {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/create', [TaskController::class, 'create'])->name('create');
    Route::post('/store', [TaskController::class, 'store'])->name('store');

    Route::get('{task}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::post('/{task}', [TaskController::class, 'update'])->name('update');

    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
});
