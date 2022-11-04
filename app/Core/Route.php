<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\InternalServerErrorException;

class Route
{
    public string $uri;
    public string $method;
    public array|string $action;

    public function __construct(string $uri, string $method, array|string|callable $action)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array|string
     */
    public function getAction(): array|string
    {
        return $this->action;
    }

    /**
     * @param string $uri
     * @return Route
     */
    public function setUri(string $uri): Route
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param string $method
     * @return Route
     */
    public function setMethod(string $method): Route
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param array|string|callable $action
     * @return Route
     */
    public function setAction(array|string|callable $action): Route
    {
        $this->action = $action;
        return $this;
    }

    public function getController(): string
    {
        return $this->action[0];
    }

    /**
     * @throws InternalServerErrorException
     */
    public function getCallable(): callable
    {
        if (is_callable($this->action)) {
            return $this->action;
        }

        if (is_array($this->action)) {
            return self::resolveCallbackFromArray($this->action);
        }
    }

    /**
     * Resolve a callback function from an Array
     *
     * @param array $callbackArray
     * @return array|null
     * @throws InternalServerErrorException
     */
    private static function resolveCallbackFromArray(array $callbackArray): ?array
    {
        [$controllerClass, $controllerMethod] = $callbackArray;

        if (class_exists($controllerClass)) {
            $controllerClass = new $controllerClass();

            if (method_exists($controllerClass, $controllerMethod)) {
                return [$controllerClass, $controllerMethod];
            } else {
                throw new InternalServerErrorException(message: "Method : $controllerMethod not exist inside " . $controllerClass::class . " class.");
            }
        } else {
            throw new InternalServerErrorException(message: "Controller : $controllerClass not exist.");
        }
    }
}
