<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Request;

/**
 * Class Router
 *
 * @category Class
 * @package  App\core
 */
class Router
{
    /**
     * List of all routes
     *
     * @var array $routes
     */
    protected array $routes = [];

    public Request $request;

    public function __construct()
    {
    }

    /**
     * Handle a Route Registration
     *
     * @param string    $method   Http method
     * @param string    $uri      Http uri
     * @param callable  $callback Callback function
     * @return void
     */
    private function handle(string $method, string $uri, callable $callback): void
    {
        $this->routes[$method][$uri] = $callback;
    }

    private function resolve(): callable | null
    {
        $method = $this->request->getMethod();
        $uri = $this->request->getUri();
        return $this->routes[$method][$uri] ?? null;
    }

    /**
     * Register a new GET route
     *
     * @param string $path Route path string
     * @param callable $callback Callable function after resolve
     * @return self
     */
    public function get(string $path, callable $callback): self
    {
        $this->handle('GET', $path, $callback);
        return $this;
    }

    /**
     * Register a new POST route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public function post(string $path, callable $callback): self
    {
        $this->handle('POST', $path, $callback);
        return $this;
    }

    /**
     * Register a new PUT route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public function put(string $path, callable $callback): self
    {
        $this->handle('PUT', $path, $callback);
        return $this;
    }

    /**
     * Register a new DELETE route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public function delete(string $path, callable $callback): self
    {
        $this->handle('DELETE', $path, $callback);
        return $this;
    }

    /**
     * Register a new PATCH route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public function patch(string $path, callable $callback): self
    {
        $this->handle('PATCH', $path, $callback);
        return $this;
    }

    public function prefix(): self
    {
        return $this;
    }

    public function middleware(): self
    {
        return $this;
    }
}
