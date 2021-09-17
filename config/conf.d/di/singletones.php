<?php

use App\AuthMiddleware\AuthMiddleware;
use App\AuthMiddleware\CartMiddleware;
use App\Http\Request;
use App\Http\Response;
use App\Renderer\Renderer;

return [
    Request::class,
    Response::class,
    Renderer::class,
    AuthMiddleware::class,
    CartMiddleware::class,
];