<?php

namespace Noovin\Validation\Rules;

class RequiredWith implements ValidationRule
{
    protected string $withField;

    public function __construct(string $withField)
    {
        $this->withField = $withField;
    }

    public function validate(string $field, array $data): bool
    {
        if (isset($data[$this->withField]) && trim($data[$this->withField]) != "") {
            return isset($data[$field]) && trim($data[$field]) != "";
        }

        return true;
    }

    public function message(): string
    {
        return "This field is required when {$this->withField} is present.";
    }
}

