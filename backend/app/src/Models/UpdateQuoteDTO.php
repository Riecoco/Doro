<?php

namespace App\Models;


class UpdateQuoteDTO
{
    public int $quoteID;
    public ?string $text = null;
    public ?string $author = null;

    private array $providedFields = [];

    public function __construct(array $data = [])
    {
        $this->quoteID = $data['id'] ?? 0;

        foreach (['text', 'author'] as $field) {
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