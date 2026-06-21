<?php

namespace App\Models;

class UpdateTaskDTO
{
    public int $id;
    public ?string $title;
    public ?bool $isCompleted;
    private array $providedFields = [];

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        foreach (['title', 'isCompleted'] as $field) {
            if (array_key_exists($field, $data)) {
                $this->$field = $data[$field];
                $this->providedFields[] = $field;
            }
        }
    }

    public function hasField(string $field): bool
    {
        return in_array($field, $this->providedFields, true);
    }
}
