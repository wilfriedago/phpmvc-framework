<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Router;
use App\Core\Request;
use App\Core\Response;
use App\Exceptions\RouteNotFoundException;

/**
 * Class Application
 *
 * @category Class
 * @package  App\Core
 */
class Application
{
    public static string $ROOT_DIR;

    public function __construct()
    {
        self::$ROOT_DIR = dirname(__DIR__);
        $this->enableRouting();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function run(): void
    {
        $request = $this->getRequest();
        $response = $this->getResponse($request);
        $response->send();
    }

    /**
     * @return void
     */
    private function enableRouting(): void
    {
        try {
            echo (new Router())->resolve($this->getRequest());
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Undocumented function
     *
     * @return Request
     */
    private function getRequest(): Request
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $headers = getallheaders();
        $body = $_POST;

        return new Request($method, $uri, $headers, $body);
    }

    /**
     * Undocumented function
     *
     * @param Request $request Http request
     * @return Response
     */
    private function getResponse(Request $request): Response
    {
        $uri = $request->getUri();
        $method = $request->getMethod();

        if (!isset($this->routes[$method][$uri])) {
            return new Response(404, 'Not Found');
        }

        $controller = $this->routes[$method][$uri];

        return $controller($request);
    }
}
