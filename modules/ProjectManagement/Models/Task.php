<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Models;

use App\Enums\LastOperationType;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'type' => TaskType::class,
        'status' => TaskStatus::class,
        'last_operation' => LastOperationType::class,
    ];

    protected $appends = [
        'start_date',
        'end_date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (new DateTime($attributes['start_date']))->format('Y-m-d'),
            set: fn ($value) => (new DateTime($value))->format('Y-m-d')
        );
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => (new DateTime($attributes['end_date']))->format('Y-m-d'),
            set: fn ($value) => (new DateTime($value))->format('Y-m-d')
        );
    }
}
