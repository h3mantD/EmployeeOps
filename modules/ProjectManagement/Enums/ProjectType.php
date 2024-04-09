<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Enums;

use App\Enums\Traits\GeneralEnumTrait;

enum ProjectType: string
{
    use GeneralEnumTrait;

    case PROJECT = 'project';
    case CRM = 'crm';
}
