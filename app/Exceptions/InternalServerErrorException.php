<?php

namespace App\Exceptions;

use App\Core\View;
use Exception;
use Throwable;

class InternalServerErrorException extends Exception
{
    /**
     * @var string
     */
    public string $view;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, string $view = "500")
    {
        parent::__construct($message, $code, $previous);

        $this->view = View::renderWithLayout($view);
    }
}
