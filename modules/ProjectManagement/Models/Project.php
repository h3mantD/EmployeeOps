<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\Models;

use App\Enums\LastOperationType;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ProjectManagement\Enums\ProjectType;

final class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'last_operation'];

    protected $casts = [
        'type' => ProjectType::class,
        'last_operation' => LastOperationType::class,
    ];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'project_employee', 'project_id', 'employee_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getMembersAttribute(): array
    {
        return $this->employees->pluck('id')->toArray();
    }
}
