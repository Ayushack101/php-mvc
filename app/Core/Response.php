<?php

namespace App\Core;

class Response
{
    private function setStatusCode(int $code): void
    {
        http_response_code($code);
    }
    public function jsonResponse(array|string $data, int $status_code = 200): void
    {
        $this->setStatusCode($status_code);
        header('Content-Type: application/json');
        echo json_encode(['data' => $data]);
        exit();
    }
    public function renderErrorPage(int $statusCode, string $message)
    {
        $this->setStatusCode($statusCode);

        if ($statusCode === 404) {
            // 404 page view Route Not Found Error
            echo View::make('error/404', ['message' => $message, 'status_code' => $statusCode]);
        } elseif ($statusCode === 500) {
            //  500 page view Internal Server Error
            echo View::make('error/404', ['message' => $message, 'status_code' => $statusCode]);
        }
        exit();
    }
}