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

    private string $method;
    private string $uri;
    private array $headers;
    private array $body;

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
        array $body = []
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
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
     * Get the body of a request
     *
     * @return array
     */
    // FIXME : Get the body of the request
    public function getBody(): array
    {

        if ($this->method === 'GET') {
            foreach ($_GET as $key => $value) {
                $this->body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method === 'POST') {
            foreach ($_POST as $key => $value) {
                $this->body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
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
