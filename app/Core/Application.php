<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\InternalServerErrorException;
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
    public static string $MIGRATION_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $database;

    public function __construct(array $config)
    {
        self::$ROOT_DIR = $config['rootDir'];
        self::$MIGRATION_DIR = $config['migrationDir'];
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
        $this->database = new Database($config['db']);
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
        $params = $_GET;

        return new Request($method, $uri, $headers, $body, $params);
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
        } catch (RouteNotFoundException $error) {
            $response = $this->response->setBody($error->view)->setStatus(404);
        } catch (InternalServerErrorException $error) {
            $response = $this->response->setBody($error->view)->setStatus(500);
        }

        return $response;
    }
}
