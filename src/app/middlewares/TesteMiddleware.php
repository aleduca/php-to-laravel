<?php

namespace app\middlewares;

use Closure;
use core\interfaces\MiddlewareInterface;
use core\library\Request;

class TesteMiddleware implements MiddlewareInterface
{
  public function handle(Request $request, Closure $next)
  {
    dump('TesteMiddleware');
    return $next($request);
  }
}
