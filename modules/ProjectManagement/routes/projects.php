<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\ProjectManagement\Http\Controllers\ProjectController;

Route::group([
    'middleware' => ['auth:web,employee'],
], function (): void {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/store', [ProjectController::class, 'store'])->name('store');
    Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
    Route::post('/{project}', [ProjectController::class, 'update'])->name('update');
    Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
});
