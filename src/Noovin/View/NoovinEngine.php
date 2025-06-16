<?php

namespace Noovin\View;

class NoovinEngine implements ViewEngine
{
    protected string $viewsPath;

    public function __construct(string $viewsPath)
    {
        $this->viewsPath = $viewsPath;
    }

    /**
     * Render a view file.
     *
     * @param string $view The name of the view file to render.
     * @return string The rendered HTML content.
     */
    public function render(string $view): string
    {
        $viewFile = "{$this->viewsPath}/{$view}.php";
        
        ob_start();
        include_once  $viewFile;
        return ob_get_clean();
    }
}
