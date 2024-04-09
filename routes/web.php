<?php

declare(strict_types=1);

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('web')->get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
    ->middleware(['auth:employee,web', 'verified'])->name('dashboard');

Route::middleware('auth:web,employee')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:web')->prefix('employees')->as('employees.')->group(function (): void {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('store');

    Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
    Route::post('/{employee}', [EmployeeController::class, 'update'])->name('update');

    Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');

    Route::post('/{employee}/update-password', [EmployeeController::class, 'updatePassword'])->name('update-password');
});

require __DIR__ . '/auth.php';
