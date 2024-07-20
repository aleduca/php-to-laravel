<?php

namespace core\library;

use core\exceptions\MiddlewareNotFoundException;
use core\interfaces\MiddlewareInterface;

class Middleware
{
  public function __construct(
    private Request $request
  ) {
  }

  private function isMiddleware($middleware)
  {
    return class_exists($middleware) && is_subclass_of($middleware, MiddlewareInterface::class);
  }

  public function handle(array $middlewares)
  {
    $middleware = array_shift($middlewares);

    if (!$middleware) {
      return;
    }

    if (!$this->isMiddleware($middleware)) {
      throw new MiddlewareNotFoundException("Middleware {$middleware} not found or not implements MiddlewareInterface");
    }

    $middleware = new $middleware;

    $middleware->handle($this->request, function () use ($middlewares) {
      $this->handle($middlewares);
    });
  }
}
