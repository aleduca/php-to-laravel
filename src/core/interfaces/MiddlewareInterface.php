<?php

namespace core\interfaces;

use Closure;
use core\library\Request;

interface MiddlewareInterface
{
  public function handle(Request $request, Closure $next);
}
