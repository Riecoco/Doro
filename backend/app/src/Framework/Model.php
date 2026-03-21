<?php

namespace App\Framework;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;

abstract class Model
{
    /**
     * Validate the model using PHP attributes
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC); //get all public properties

        foreach ($properties as $property) {
            //Ignore if not initialized
            if (!$property->isInitialized($this)) {
                continue;
            }

            // Get all the attributes of the properties
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                // Get the attribute class (Like Required or MinLength, etc)
                $attributeInstance = $attribute->newInstance();

                if (!$attributeInstance->isValid($property->getValue($this))) {
                    throw new InvalidArgumentException($attributeInstance->message);
                }
            }
        }
    }
}
