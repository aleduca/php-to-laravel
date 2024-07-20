<?php

namespace app\middlewares;

use Closure;
use core\interfaces\MiddlewareInterface;
use core\library\Request;

class GuestMiddleware implements MiddlewareInterface
{
  public function handle(Request $request, Closure $next)
  {
    dump('GuestMiddleware');

    return $next($request);
  }
}
