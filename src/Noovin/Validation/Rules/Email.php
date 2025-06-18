<?php

namespace Noovin\Validation\Rules;

class Email implements ValidationRule
{
    public function validate(string $field, array $data): bool
    {
        if (! isset($data[$field])) return false;

        $email = strtolower(trim($data[$field]));
        $split = explode("@", $email);
        if (count($split) !== 2) return false;

        [$username, $domain] = $split;
        $split = explode(".", $domain);
        if (count($split) !== 2) return false;

        [$label, $tld] = $split;
        return strlen($username) > 0 && strlen($label) > 0 && strlen($tld) > 0;
    }

    public function message(): string
    {
        return "Email has invalid format.";
    }
}

