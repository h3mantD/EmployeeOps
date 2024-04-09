<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Enums;

use App\Enums\Traits\GeneralEnumTrait;

enum TaskType: string
{
    use GeneralEnumTrait;

    case GENERAL = 'general';
    case DEVELOPMENT = 'development';
    case BUG = 'bug';
    case CHANGE_REQUEST = 'change_request';
}
