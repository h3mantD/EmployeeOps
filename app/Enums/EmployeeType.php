<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\GeneralEnumTrait;

enum EmployeeType: string
{
    use GeneralEnumTrait;

    case SUPER_ADMIN = 'super_admin';
    case EMPLOYEE = 'user';
}
