<?php

namespace App\Core;

class Controller
{
    protected function render(string $view, array $params = []): string
    {
        return View::renderWithLayout($view, $params);
    }
}
