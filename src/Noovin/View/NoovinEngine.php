<?php

namespace Noovin\View;

class NoovinEngine implements ViewEngine
{
    protected string $viewsPath;

    protected string $defaultLayout = "app";

    protected string $contentAnnotation = "@content";

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
    public function render(string $view, array $data = [], ?string $layout = null): string
    {
        $layoutContent = $this->renderLayout($layout ?? $this->defaultLayout);
        $viewContent = $this->renderView($view, $data);

        return str_replace($this->contentAnnotation, $viewContent, $layoutContent);
    }

    public function renderView(string $view, array $data = []): string
    {
        return $this->viewOutput("{$this->viewsPath}/{$view}.php", $data);
    }

    public function renderLayout(string $layout): string
    {
        return $this->viewOutput("{$this->viewsPath}/layouts/{$layout}.php");
    }

    public function viewOutput(string $viewFile, array $data = []): string
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        
        ob_start();

        include_once $viewFile;

        return ob_get_clean();
    }
}
