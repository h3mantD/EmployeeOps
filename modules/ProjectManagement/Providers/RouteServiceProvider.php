<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;

final class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }
}
