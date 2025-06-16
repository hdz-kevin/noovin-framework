<?php

namespace Noovin\View;

interface ViewEngine
{
    public function render(string $view, array $data = [], ?string $layout = null): string;
}
