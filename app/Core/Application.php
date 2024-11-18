<?php

namespace App\Core;

class Application
{
    private Router $router;

    private Request $request;

    private Response $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        // connecting to database
        DB::mysql_connect();
    }

    public function get(string $route, callable|array $action, array $middlewares = []): Router
    {
        return $this->router->get($route, $action, $middlewares);
    }

    public function post(string $route, callable|array $action, array $middlewares = []): Router
    {
        return $this->router->post($route, $action, $middlewares);
    }

    public function update(string $route, callable|array $action, array $middlewares = []): Router
    {
        return $this->router->update($route, $action, $middlewares);
    }

    public function delete(string $route, callable|array $action, array $middlewares = []): Router
    {
        return $this->router->delete($route, $action, $middlewares);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}