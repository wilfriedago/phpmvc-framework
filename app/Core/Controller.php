<?php

declare(strict_types=1);

namespace App\Core;

class Controller
{
    public string $layout = 'main';

    protected function render(string $view, array $params = []): string
    {
        return View::renderWithLayout($view, $this->layout, $params);
    }

    protected function setLayout(string $layout):Controller
    {
        $this->layout = $layout;
        return $this;
    }
}
