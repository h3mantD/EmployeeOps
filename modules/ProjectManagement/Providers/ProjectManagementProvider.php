<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Providers;

use Illuminate\Support\ServiceProvider;

final class ProjectManagementProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app->register(RouteServiceProvider::class);
    }
}
