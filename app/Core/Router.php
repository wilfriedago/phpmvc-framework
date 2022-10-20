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
     * Resolve new Route
     *
     * @param Request $request
     * @return Response
     * @throws RouteNotFoundException
     */
    public function resolve(Request $request): Response
    {
        $method = $request->getMethod();
        $uri = $request->getUri();
        $callback = self::$ROUTES[$method][$uri] ?? null;

        if (!$callback) {
            throw new RouteNotFoundException(view: $this->renderViewWithLayout("404"));
        }

        $responseAction = call_user_func($callback);

        $responseBody = $this->renderViewWithLayout($responseAction);

        return new Response(body:call_user_func($callback));
    }

    /**
     * @param array $callbackArray
     * @return mixed|void
     */
    public static function resolveCallbackFromArray(array $callbackArray)
    {
        [$controllerClass, $controllerMethod] = $callbackArray;

        if (class_exists($controllerClass)) {
            $controllerClass = new $controllerClass();

            if (method_exists($controllerClass, $controllerMethod)) {
                if (is_callable($controllerMethod)) {
                    return call_user_func_array([$controllerClass, $controllerMethod], []);
                }
            }
        }
    }

    /**
     * Handle a Route Registration
     *
     * @param string $method Http method
     * @param string $uri Http uri
     * @param callable|array $callback Callback function
     * @return void
     */
    private static function handle(string $method, string $uri, callable|array $callback): void
    {
        if (is_callable($callback)) {
            self::$ROUTES[$method][$uri] = $callback;
        }

        if (is_array($callback)) {
            self::$ROUTES[$method][$uri] = self::resolveCallbackFromArray($callback);
        }
    }

    /**
     * @param string $view
     * @return string
     */
    public function renderView(string $view): string
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    /**
     * @param string $layout
     * @return string
     */
    public function renderLayout(string $layout = 'main'): string
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    /**
     * @param string $view
     * @return string
     */
    public function renderViewWithLayout(string $view) : string
    {
        $layout = $this->renderLayout();
        $viewContent = $this->renderView($view);
        return str_replace('{{content}}', $viewContent, $layout);
    }

    /**
     * Register a new GET route
     *
     * @param string $path
     * @param callable|array $callback
     * @return self
     */
    public static function get(string $path, callable|array $callback): self
    {
        self::handle('GET', $path, $callback);
        return new static();
    }

    /**
     * Register a new POST route
     *
     * @param string $path
     * @param callable|array $callback
     * @return self
     */
    public static function post(string $path, callable|array $callback): self
    {
        self::handle('POST', $path, $callback);
        return new static();
    }

    /**
     * Register a new PUT route
     *
     * @param string $path
     * @param callable|array $callback
     * @return self
     */
    public static function put(string $path, callable|array $callback): self
    {
        self::handle('PUT', $path, $callback);
        return new static();
    }

    /**
     * Register a new DELETE route
     *
     * @param string $path
     * @param callable|array $callback
     * @return self
     */
    public static function delete(string $path, callable|array $callback): self
    {
        self::handle('DELETE', $path, $callback);
        return new static();
    }

    /**
     * Register a new PATCH route
     *
     * @param string $path
     * @param callable|array $callback
     * @return self
     */
    public static function patch(string $path, callable|array $callback): self
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

    /**
     * @return $this
     */
    public function middleware(): self
    {
        return new static();
    }
}
