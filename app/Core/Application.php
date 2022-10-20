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
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct($rootDir)
    {
        self::$ROOT_DIR = $rootDir;
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function run(): void
    {
        $this->request = $this->getRequest();
        $this->response = $this->getResponse($this->request);
        $this->response->send();
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
        try {
            $response = $this->router->resolve($request);
        } catch (RouteNotFoundException $e) {
            $response = $this->response
                ->setBody($e->view)
                ->setStatus(404);
        }

        return $response;
    }
}
