<?php

namespace core\library;

use core\exceptions\ControllerNotFoundException;
use DI\Container;

class Router
{
  protected array $routes = [];
  protected ?string $controller = null;
  protected string $action;
  protected array $parameters = [];

  public function __construct(
    private Container $container
  ) {
  }

  public function add(
    string $method,
    string $uri,
    array $route
  ) {
    $this->routes[$method][$uri] = $route;
  }

  public function execute()
  {
    foreach ($this->routes as $request => $routes) {
      if ($request === REQUEST_METHOD) {
        return $this->handleUri($routes);
      }
    }
  }

  private function handleUri(array $routes)
  {
    foreach ($routes as $uri => $route) {

      if ($uri === REQUEST_URI) {
        [$this->controller, $this->action] = $route;
        break;
      }

      $pattern = str_replace('/', '\/', trim($uri, '/'));
      if ($uri !== '/' && preg_match("/^$pattern$/", trim(REQUEST_URI, '/'), $this->parameters)) {
        [$this->controller, $this->action] = $route;
        unset($this->parameters[0]);
        break;
      }
    }

    if ($this->controller) {
      return $this->handleController(
        $this->controller,
        $this->action,
        $this->parameters
      );
    }

    return $this->handleNotFound();
  }

  private function handleController(
    string $controller,
    string $action,
    array $parameters
  ) {
    if (!class_exists($controller) || !method_exists($controller, $action)) {
      throw new ControllerNotFoundException(
        "[$controller::$action] does not exist."
      );
    }
    $controller = $this->container->get($controller);
    $this->container->call([$controller, $action], [...$parameters]);
  }

  private function handleNotFound()
  {
    dump('not found controller');
  }
}
