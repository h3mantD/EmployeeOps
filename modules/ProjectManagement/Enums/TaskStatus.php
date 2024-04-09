<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Enums;

use App\Enums\Traits\GeneralEnumTrait;

enum TaskStatus: string
{
    use GeneralEnumTrait;

    case TODO = 'todo';
    case RUNNING = 'running';
    case COMPLETED = 'completed';
}
