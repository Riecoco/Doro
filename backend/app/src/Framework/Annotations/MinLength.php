<?php

namespace App\Framework\Annotations;

use Attribute;

#[Attribute]
class MinLength
{
    public function __construct(private int $min) {}

    public function validate($value, string $propertyName): void
    {
        if (strlen($value) < $this->min) {
            throw new \InvalidArgumentException("$propertyName must be at least {$this->min} characters");
        }
    }
}
