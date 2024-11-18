<?php

namespace App\Exception;

class RouteNotFoundException extends \Exception
{
    protected string $error_message;

    public function __construct(string $message = "", int $code = 404)
    {
        $this->error_message = $message;

        parent::__construct($message, $code);
    }

    public function getFMessage(): string
    {
        return $this->error_message . ' Status Code: ' . $this->getCode() . $this->getTraceAsString() . ' Line-' . $this->getLine() . ' ' . $this->getFile();
    }
}