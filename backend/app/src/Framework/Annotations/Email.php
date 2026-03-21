<?php

namespace App\Framework\Annotations;

use Attribute;

#[Attribute]
class Email
{
    public function validate($value, string $propertyName): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("$propertyName must be a valid email address");
        }
    }
}
