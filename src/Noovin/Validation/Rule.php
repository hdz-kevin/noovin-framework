<?php

namespace Noovin\Validation;

use Noovin\Validation\Rules\Email;
use Noovin\Validation\Rules\Required;
use Noovin\Validation\Rules\RequiredWhen;
use Noovin\Validation\Rules\RequiredWith;
use Noovin\Validation\Rules\ValidationRule;

class Rule
{
    public static function email(): ValidationRule
    {
        return new Email();
    }

    public static function required(): ValidationRule
    {
        return new Required();
    }

    public static function requiredWith(string $withField): ValidationRule
    {
        return new RequiredWith($withField);
    }

    public static function requiredWhen(string $whenField, string $operator, mixed $value): ValidationRule
    {
        return new RequiredWhen($whenField, $operator, $value);
    }
}
