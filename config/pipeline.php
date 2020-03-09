<?php

use App\Http\Middleware;

/** @var \Framework\Http\Application $app */

$app->pipe(Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware::class);
$app->pipe(Middleware\ResponseLoggerMiddleware::class);
$app->pipe(Framework\Http\Middleware\RouteMiddleware::class);

//$app->pipe('login', Middleware\BasicAuthMiddleware::class);
$app->pipe('edit', Middleware\BasicAuthMiddleware::class);

$app->pipe(Framework\Http\Middleware\DispatchMiddleware::class);
