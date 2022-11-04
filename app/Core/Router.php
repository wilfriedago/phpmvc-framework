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
     * Register a new GET route with the router.
     *
     * @param string $uri
     * @param array|string|callable|null $action
     * @return void
     */
    public static function get(string $uri, array|string|callable|null $action = null): void
    {
        self::handle(new Route($uri, 'GET', $action));
    }

    /**
     * Register a new POST route with the router.
     *
     * @param string $uri
     * @param array|string|callable|null $action
     * @return void
     */
    public static function post(string $uri, array|string|callable|null $action = null): void
    {
        self::handle(new Route($uri, 'POST', $action));
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param string $uri
     * @param array|string|callable|null $action
     * @return void
     */
    public static function put(string $uri, array|string|callable|null $action = null): void
    {
        self::handle(new Route($uri, 'PUT', $action));
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param string $uri
     * @param array|string|callable|null $action
     * @return void
     */
    public static function patch(string $uri, array|string|callable|null $action = null): void
    {
        self::handle(new Route($uri, 'PATCH', $action));
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param string $uri
     * @param array|string|callable|null $action
     * @return void
     */
    public static function delete(string $uri, array|string|callable|null $action = null): void
    {
        self::handle(new Route($uri, 'DELETE', $action));
    }

    /**
     * Handle a Route Registration
     *
     * @param Route $route
     * @return void
     */
    private static function handle(Route $route): void
    {
        $uri = $route->getUri();
        $method = $route->getMethod();
        self::$ROUTES[$method][$uri] = $route;
    }

    /**
     * Resolve a Route from Http Request
     *
     * @param Request $request
     * @return Response
     * @throws RouteNotFoundException
     */
    public function resolve(Request $request): Response
    {
        $uri = $request->getUri();
        $method = $request->getMethod();
        $route = self::$ROUTES[$method][$uri] ?? null;

        if (!$route) {
            throw new RouteNotFoundException();
        }

        $callback = $route->getCallable();

        $callbackResponse = call_user_func($callback, $request);

        return ($callbackResponse instanceof Response) ? $callbackResponse : new Response(body: $callbackResponse);
    }

    /**
     * @param string $prefix
     * @return Router
     */
    public function prefix(string $prefix): Router
    {
        return $this;
    }

    /**
     * @param string $version
     * @param Closure $param
     * @return void
     */
    public static function api(string $version, Closure $param): void
    {
    }

    /**
     * @param string $path
     * @return void
     */
    public function middleware(string $path): void
    {
    }
}
