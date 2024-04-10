<?php

declare(strict_types=1);

namespace Modules\ProjectManagement\DataObjects;

use App\Enums\LastOperationType;
use Illuminate\Http\Request;
use Modules\ProjectManagement\Enums\ProjectType;

final readonly class ProjectPayload
{
    public function __construct(
        public string $name,
        public ProjectType $type,
        public array $members,
        public LastOperationType $lastOperation = LastOperationType::CREATE,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->name,
            type: ProjectType::from($request->type),
            members: $request->members,
        );
    }

    public static function fromArray(array $data): self
    {
        $lastOperation = LastOperationType::CREATE;
        if ($data['last_operation'] ?? false) {
            if ($data['last_operation'] instanceof LastOperationType) {
                $lastOperation = $data['last_operation'];
            } else {
                $lastOperation = LastOperationType::from($data['last_operation']);
            }
        }

        return new self(
            name: $data['name'],
            type: ProjectType::from($data['type']),
            members: $data['members'],
            lastOperation: $lastOperation,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'members' => $this->members,
            'last_operation' => $this->lastOperation,
        ];
    }

    public function setLastOperationType(LastOperationType $lastOperation): self
    {
        return new self(
            name: $this->name,
            type: $this->type,
            members: $this->members,
            lastOperation: $lastOperation,
        );
    }
}
