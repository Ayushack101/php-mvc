<?php

namespace App\Core;

use App\Exception\ViewNotFoundException;

class View
{
    const VIEW_PATH = __DIR__ . '/../../views';

    protected string $view;

    protected array $params = [];

    public function __construct(string $view, array $params = [])
    {
        $this->view = $view;
        $this->params = $params;
    }

    public static function make(string $view, array $params = []): static
    {
        return new static($view, $params);
    }

    public function render(): string
    {
        $viewPath = self::VIEW_PATH . '/' . $this->view . '.php';

        try {
            if (!file_exists($viewPath)) {
                throw new ViewNotFoundException("View Not Found: " . $viewPath, 500);
            }
        } catch (ViewNotFoundException $e) {
            $e->getFMessage();
        }

        foreach ($this->params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include $viewPath;

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $name)
    {
        return $this->params[$name] ?? null;
    }
}