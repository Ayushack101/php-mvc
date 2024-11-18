<?php

namespace App\Exception;

use App\Core\Response;

class ViewNotFoundException extends \Exception
{
    private Response $response;

    public function __construct(string $message = "", int $code = 500)
    {
        $this->response = new Response();
        $this->message = $message;
        $this->code = $code;
    }

    public function getFMessage(): void
    {
        $this->response->renderErrorPage($this->code, $this->message);
    }
}