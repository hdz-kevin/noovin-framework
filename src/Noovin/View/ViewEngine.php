<?php

namespace Noovin\View;

interface ViewEngine
{
    public function render(string $view): string;
}
