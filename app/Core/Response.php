<?php

declare(strict_types=1);

namespace App\Core;

class Response
{

    private int $status;
    private string $body;
    private array $headers = [];

    public function __construct()
    {
    }

    /**
     * Send the response to the client
     *
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $header) {
            header($header);
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
        $this->headers['Content-Type'] = 'application/json';
        $this->body = json_encode($data);
        return $this;
    }

    /**
     * Set the response http status code
     *
     * @param integer $code
     * @return self
     */
    public function status(int $code): self
    {
        $this->status = $code;
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
