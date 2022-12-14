<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Class Request
 *
 * @category Class
 * @package  App\Core
 */
class Request
{

    public string $method;
    public string $uri;
    public array $headers;
    public array $body;
    public array $params;

    /**
     * Class Request Constructor
     *
     * @param string $method  Request Method
     * @param string $uri     Request Uri
     * @param array  $headers Request Headers
     * @param array  $body    Request Body
     */
    public function __construct(
        string $method = "",
        string $uri = "",
        array $headers = [],
        array $body = [],
        array $params = []
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->params = $params;
    }

    /**
     * Get the value of the Http Method used by the Request
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public function isGet():bool
    {
        return $this->method === 'GET';
    }

    public function isPost():bool
    {
        return $this->method === 'POST';
    }

    /**
     * Get the value of uri used by the Request
     *
     * @return string
     */
    public function getUri(): string
    {
        $uri = $this->uri ?? '/';
        return explode('?', $uri)[0];
    }

    /**
     * Get all request parameters
     *
     * @return array
     */
    // FIXME : Get the parameters of the request
    public function getQuery(): array
    {
        return [];
    }

    /**
     * Get all request headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get a request params
     *
     * @return array
     */
    public function getParams(): array
    {
        foreach ($_GET as $key => $value) {
            $this->params[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $this->params;
    }

    /**
     * Get the body of a request
     *
     * @return array
     */
    public function getBody(): array
    {
        foreach ($_POST as $key => $value) {
            $this->body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $this->body;
    }

    // TODO : Refactor this code
    public function getAuthorizationHeader(): ?string
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));

            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        return $headers;
    }

    // TODO : Refactor this code
    public function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();

        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
