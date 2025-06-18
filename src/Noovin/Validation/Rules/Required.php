<?php

namespace Noovin\Validation\Rules;

class Required implements ValidationRule
{
    public function validate(string $field, array $data): bool
    {
        return isset($data[$field]) && trim($data[$field]) !== "";
    }

    public function message(): string
    {
        return "This Field is required.";
    }
}
