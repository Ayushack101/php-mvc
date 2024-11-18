<?php

namespace App\Core;

use App\Exception\RouteNotFoundException;
use Exception;

class Router
{
    private array $routes;
    private Request $request;
    private Response $response;
    private array $routeMiddlewares = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    private function register(string $requestMethod, string $route, callable|array $action, array $middlewares = []): self
    {
        $this->routes[$requestMethod][$route] = $action;
        $this->routeMiddlewares[$requestMethod][$route] = $middlewares;
        return $this;
    }


    public function get(string $route, callable|array $action, array $middlewares = []): self
    {
        return $this->register('get', $route, $action, $middlewares);
    }

    public function post(string $route, callable|array $action, array $middlewares = []): self
    {
        return $this->register('post', $route, $action, $middlewares);
    }

    public function update(string $route, callable|array $action, array $middlewares = []): self
    {
        return $this->register('update', $route, $action, $middlewares);
    }

    public function delete(string $route, callable|array $action, array $middlewares = []): self
    {
        return $this->register('delete', $route, $action, $middlewares);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve()
    {
        try {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();

            $action = $this->routes[$method][$path] ?? null;

            if (!$action) {
                throw new RouteNotFoundException('Route not found for URI: ' . $path);
            }

            // Apply route-specific middlewares
            $middlewares = $this->routeMiddlewares[$method][$path] ?? [];
            foreach (array_reverse($middlewares) as $middleware) {
                if (class_exists($middleware)) {
                    $middlewareInstance = new $middleware();
                    if (method_exists($middlewareInstance, 'handle')) {
                        $middlewareInstance->handle($this->request, $this->response);
                    } else {
                        throw new Exception("Method does not exist on Class: " . $middleware . ': ' . $method);
                    }
                } else {
                    throw new Exception("Middleware class does not exist Class: " . $middleware);
                }
            }

            if (is_callable($action)) {
                return call_user_func($action);
            }

            if (is_array($action)) {
                [$class, $method] = $action;
                if (class_exists($class)) {
                    $classInstance = new $class($this->request, $this->response);
                    if (method_exists($classInstance, $method)) {
                        return call_user_func_array([$classInstance, $method], []);
                    } else {
                        throw new Exception("Method does not exist on Class: " . $class . ': ' . $method);
                    }
                }
                throw new Exception("Class does not exist: " . $class);
            }
        } catch (RouteNotFoundException $e) {
            $this->response->renderErrorPage(404, $e->getMessage());
        } catch (Exception $e) {
            $this->response->renderErrorPage(500, $e->getMessage());
        }
    }
}
