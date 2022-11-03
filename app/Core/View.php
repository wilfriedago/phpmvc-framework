<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public static function render(string $view, array $params): string
    {

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    /**
     * @param string $layout
     * @return string
     */
    private static function renderLayout(string $layout): string
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    /**
     * @param string $view
     * @param string $layout
     * @param array $params
     * @return string
     */
    public static function renderWithLayout(string $view, string $layout = 'main', array $params = []) : string
    {
        $layout = self::renderLayout($layout);
        $viewContent = self::render($view, $params);
        return str_replace('{{content}}', $viewContent, $layout);
    }
}
