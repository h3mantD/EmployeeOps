<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function (): void {
    Route::prefix('/projects')->as('projects.')->group(base_path('modules/ProjectManagement/routes/projects.php'));
    Route::prefix('/projects/{project}/tasks')
        ->as('tasks.')->group(base_path('modules/ProjectManagement/routes/tasks.php'));
});
