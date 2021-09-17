<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\CartMiddleware;
use App\Http\Request;
use App\Http\Response;
use App\Renderer\Renderer;

return [
    Request::class,
    Response::class,
    Renderer::class,
    ModelManager::class,
    AuthMiddleware::class,
    CartMiddleware::class,
];