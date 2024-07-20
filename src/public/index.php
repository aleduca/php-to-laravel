<?php
session_start();

require '../vendor/autoload.php';

// $middlewares = [
//   'TesteMiddleware',
//   'OutroTesteMiddleware',
//   'GuestMiddleware',
//   'AuthMiddleware',
// ];

// function TesteMiddleware($request, Closure $next)
// {
//   dump('TesteMiddleware');
//   return $next($request);
// }

// function OutroTesteMiddleware($request, Closure $next)
// {
//   dump('OutroTesteMiddleware');
//   return $next($request);
// }

// function GuestMiddleware($request, Closure $next)
// {
//   dump('GuestMiddleware');
//   return $next($request);
// }
// function AuthMiddleware($request, Closure $next)
// {
//   dump('AuthMiddleware');
//   return $next($request);
// }

// function execute(array $middlewares)
// {
//   $middleware = array_shift($middlewares);

//   if (!$middleware) {
//     return;
//   }

//   $middleware('request', function () use ($middlewares) {
//     execute($middlewares);
//   });
// }

// execute($middlewares);

require '../bootstrap/app.php';

require '../routes/web.php';
