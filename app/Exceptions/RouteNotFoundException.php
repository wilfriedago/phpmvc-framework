<?php

namespace App\Exceptions;

use Throwable;

class RouteNotFoundException extends \Exception
{
    /**
     * @var string
     */
    public string $view;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, string $view = "")
    {
        parent::__construct($message, $code, $previous);

        $this->view = $view;
    }
}
