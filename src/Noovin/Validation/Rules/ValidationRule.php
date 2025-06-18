<?php

namespace Noovin\Validation\Rules;

interface ValidationRule
{
    public function validate(string $field, array $data): bool;

    public function message(): string;
}
