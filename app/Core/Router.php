<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\RouteNotFoundException;

/**
 * Class Router
 *
 * @category Class
 * @package  App\core
 */
class Router
{
    /**
     * List of all Application ROUTES
     */
    public static array $ROUTES = [];

    public function __construct()
    {
    }

    /**
     * Handle a Route Registration
     *
     * @param string $method Http method
     * @param string $uri Http uri
     * @param callable $callback Callback function
     * @return void
     */
    private static function handle(string $method, string $uri, callable $callback): void
    {
        self::$ROUTES[$method][$uri] = $callback;
    }

    /**
     * Resolve new Route
     *
     * @param Request $request
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function resolve(Request $request): mixed
    {
        $method = $request->getMethod();
        $uri = $request->getUri();
        $action = self::$ROUTES[$method][$uri] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        return call_user_func($action);
    }

    /**
     * Register a new GET route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public static function get(string $path, callable $callback): self
    {
        self::handle('GET', $path, $callback);
        return new static();
    }

    /**
     * Register a new POST route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public static function post(string $path, callable $callback): self
    {
        self::handle('POST', $path, $callback);
        return new static();
    }

    /**
     * Register a new PUT route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public static function put(string $path, callable $callback): self
    {
        self::handle('PUT', $path, $callback);
        return new static();
    }

    /**
     * Register a new DELETE route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public static function delete(string $path, callable $callback): self
    {
        self::handle('DELETE', $path, $callback);
        return new static();
    }

    /**
     * Register a new PATCH route
     *
     * @param string $path
     * @param callable $callback
     * @return self
     */
    public static function patch(string $path, callable $callback): self
    {
        self::handle('PATCH', $path, $callback);
        return new static();
    }

    /**
     * @param string $path
     * @return static
     */
    public static function prefix(string $path): self
    {
        return new static();
    }

    public function middleware(): self
    {
        return new static();
    }
}
