<?php

namespace App\Framework\Annotations;

use Attribute;

#[Attribute]
class MaxLength
{
    public function __construct(private int $max) {}

    public function validate($value, string $propertyName): void
    {
        if (strlen($value) > $this->max) {
            throw new \InvalidArgumentException("$propertyName must be at most {$this->max} characters");
        }
    }
}
