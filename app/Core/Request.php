<?php

namespace App\Core;

require_once __DIR__ . '/../config/config.php';

class Request
{
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = str_replace(ROOT_DIRECTORY, "/", $path);

        $position = strpos($path, '?');

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getQueryParameters(): array
    {
        $queryParams = [];
        foreach ($_GET as $key => $value) {
            $queryParams[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Remove 'url' key if it exists in the array
        if (array_key_exists('url', $queryParams)) {
            unset($body['url']);
        }

        return $queryParams;
    }

    public function getBody(): array
    {
        $body = [];

        if ($this->getMethod() === 'post') {
            if ($this->isJsonRequest()) {
                $data = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $body = $data;
                }
            } else {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        } elseif ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        // Remove 'url' key if it exists in the array
        if (array_key_exists('url', $body)) {
            unset($body['url']);
        }

        return $body;
    }

    public function isJsonRequest()
    {
        return isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }

    public function getHeader(string $header)
    {
        $header = 'HTTP_' . strtoupper(str_replace('-', '_', $header));
        return $_SERVER[$header] ?? null;
    }
}