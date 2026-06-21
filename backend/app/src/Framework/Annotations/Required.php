<?php

namespace App\Framework\Annotations;

use Attribute;

#[Attribute]
class Required
{
    public function validate($value, string $propertyName): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("$propertyName is required");
        }
    }
}
