<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Models;

use App\Enums\LastOperationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ProjectManagement\Enums\TaskStatus;
use Modules\ProjectManagement\Enums\TaskType;

final class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'project_id',
        'start_date',
        'end_date',
        'type',
        'status',
        'last_operation',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'type' => TaskType::class,
        'status' => TaskStatus::class,
        'last_operation' => LastOperationType::class,
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
