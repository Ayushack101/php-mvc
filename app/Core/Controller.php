<?php

namespace App\Core;

class Controller
{
    protected Request $request;

    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    protected function jsonResponse(array|string $data, int $status_code): void
    {
        $this->response->jsonResponse($data, $status_code);
    }

    protected function getQueryParameters(): array
    {
        return $this->request->getQueryParameters();
    }

    protected function getBody(): array
    {
        return $this->request->getBody();
    }
}