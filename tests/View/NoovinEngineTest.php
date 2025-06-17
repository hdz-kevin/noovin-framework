<?php

namespace Noovin\Tests\View;

use Noovin\View\NoovinEngine;
use PHPUnit\Framework\TestCase;

class NoovinEngineTest extends TestCase
{
    public function test_render_template_with_parameters()
    {
        $param1 = "Hello";
        $param2 = 2;
        $expectedOutput = "
            <html>
                <body>
                    <h1>$param1</h1>
                    <p>$param2</p>
                </body>
            </html>
        ";

        $engine = new NoovinEngine(__DIR__."/views");
        $output = $engine->render("test", compact('param1', 'param2'), "layout");

        $this->assertEquals(
            // print_r(str_replace(["\n", " "], "", $expectedOutput));
            preg_replace("/\s*/", "", $expectedOutput),
            preg_replace("/\s*/", "", $output)
        );
    }
}
