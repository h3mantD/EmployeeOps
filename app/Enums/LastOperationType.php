<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\GeneralEnumTrait;

enum LastOperationType: string
{
    use GeneralEnumTrait;

    case CREATE = 'A';
    case UPDATE = 'E';
    case DELETE = 'D';
}
