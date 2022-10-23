<?php

namespace App\Core;

class Controller
{
    protected static function render(string $view, array $params = []): string
    {
        return View::renderWithLayout($view, $params);
    }
}
