<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Class Response
 *
 * @category Class
 * @package  App\Core
 */
class Response
{

    /**
     * @var int
     */
    private int $status = 200;
    /**
     * @var string
     */
    private string $body = "";
    /**
     * @var array|string[]
     */
    private array $headers = ["Content-type" => 'text/html; charset=UTF-8'];

    public function __construct(int $status, string $body, array $headers)
    {
    }

    /**
     * @param array $headers
     * @return Response
     */
    public function setHeaders(array $headers): Response
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $body
     * @return Response
     */
    public function setBody(string $body): Response
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param int $status
     * @return Response
     */
    public function setStatus(int $status): Response
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Send the response to the client
     *
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $header => $value) {
            header("$header:$value");
        }

        echo $this->body;
    }

    /**
     * Return a json response
     *
     * @param array $data
     * @return self
     */
    public function json(array $data): self
    {
        $this->headers['Content-type'] = 'application/json';
        $this->body = json_encode($data);
        return $this;
    }

    /**
     * Redirect to a given url
     *
     * @param string $url
     * @return self
     */
    public function redirect(string $url): self
    {
        $this->status = 301;
        $this->headers['Location'] = $url;
        return $this;
    }
}
