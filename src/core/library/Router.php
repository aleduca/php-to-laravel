<?php

namespace core\library;

use core\controllers\ErrorController;
use core\exceptions\ControllerNotFoundException;
use core\exceptions\ResponseException;
use DI\Container;

class Router
{
  protected array $routes = [];
  protected ?string $controller = null;
  protected string $action;
  protected array $parameters = [];
  protected array|string $middlewares;

  public function __construct(
    private Container $container,
    private Request $request
  ) {
  }

  public function add(
    string $method,
    string $uri,
    array $route
  ) {
    $this->routes[$method][$uri] = [
      'controller' => $route[0],
      'action' => $route[1],
      'middlewares' => []
    ];

    return $this;
  }

  public function middleware(
    string|array $middlewares
  ) {
    if (isset($this->routes[REQUEST_METHOD])) {
      $this->routes[REQUEST_METHOD][array_key_last($this->routes[REQUEST_METHOD])]['middlewares'] = $middlewares;
    }
  }

  public function execute()
  {
    $requestMethod = REQUEST_METHOD;

    if ($this->request->get('_method')) {
      $requestMethod = strtoupper($this->request->get('_method'));
    }

    foreach ($this->routes as $request => $routes) {
      if ($request === $requestMethod) {
        return $this->handleUri($routes);
      }
    }
  }

  private function handleUri(array $routes)
  {
    foreach ($routes as $uri => $route) {

      if ($uri === REQUEST_URI) {
        ['controller' => $this->controller, 'action' => $this->action, 'middlewares' => $this->middlewares] = $route;
        break;
      }

      $pattern = str_replace('/', '\/', trim($uri, '/'));
      if ($uri !== '/' && preg_match("/^$pattern$/", trim(REQUEST_URI, '/'), $this->parameters)) {
        ['controller' => $this->controller, 'action' => $this->action, 'middlewares' => $this->middlewares] = $route;
        unset($this->parameters[0]);
        break;
      }
    }

    if ($this->controller) {
      $this->handleMiddleware();
      $this->handleController();
      return;
    }

    return $this->handleNotFound();
  }

  private function handleMiddleware()
  {
    $middlewares = [...(array)resolve('middlewares'), ...(array)$this->middlewares];

    if ($middlewares) {
      return (new Middleware($this->request))->handle($middlewares);
    }
    // dd($this->middlewares);
  }

  private function handleController()
  {
    if (!class_exists($this->controller) || !method_exists($this->controller, $this->action)) {
      throw new ControllerNotFoundException(
        "[$this->controller::$this->action] does not exist."
      );
    }
    $controller = $this->container->get($this->controller);
    $response = $this->container->call([$controller, $this->action], [...$this->parameters]);

    $this->handleResponse($response);
  }

  private function handleResponse(mixed $response)
  {
    if (is_array($response)) {
      $response = response()->json($response);
    }

    if (is_string($response)) {
      $response = response($response);
    }

    if (!$response instanceof Response) {
      throw new ResponseException("Controller action must return a Response object.");
    }

    $response->send();
  }

  private function handleNotFound()
  {
    $response = (new ErrorController)->notFound();
    $this->handleResponse($response);
  }
}
