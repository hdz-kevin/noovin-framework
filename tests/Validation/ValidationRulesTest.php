<?php

namespace Noovin\Tests\Validation;

use Noovin\Validation\Rule;
use PHPUnit\Framework\TestCase;

class ValidationRulesTest extends TestCase
{
    public static function emails(): array
    {
        return [
            ["kevin@kevin.com", true],
            ["another@domain.com", true],
            ["username@domain.c", true],
            ["invalid-email", false],
            ["hello@", false],
            ["@missingusername.com", false],
            ["username@.com", false],
            ["", false],
            [null, false],
            [12, false],
        ];
    }

    /**
     * @dataProvider emails
     */
    public function test_email(string|int|null $email, bool $expected)
    {
        $rule = Rule::email();
        $data = ["email" => $email];

        $this->assertEquals($expected, $rule->validate("email", $data));
    }

    public static function requiredData(): array
    {
        return [
            ["field", ["field" => "value"], true],
            ["field", ["field" => ""], false],
            ["field", ["field" => null], false],
            ["field", [], false],
            ["field", ["another_field" => "value"], false],
            ["field", ["another_field" => "value", "field" => "value"], true],
        ];
    }

    /**
     * @dataProvider requiredData
     */
    public function test_required(string $field, array $data, bool $expected)
    {
        $rule = Rule::required();

        $this->assertEquals($expected, $rule->validate($field, $data));
    }

    public function test_required_with()
    {
        $field = "color";
        $withField = "product";
        $rule = Rule::requiredWith($withField);
        $data1 = ["product" => "Keyboard", "color" => "grey"];
        $data2 = ["product" => "Keyboard"];
        $data4 = ["price", 123];
        $data3 = ["color" => "grey"];

        $this->assertTrue($rule->validate($field, $data1));
        $this->assertFalse($rule->validate($field, $data2));
        $this->assertTrue($rule->validate($field, $data3));
        $this->assertTrue($rule->validate($field, $data4));
    }
}
