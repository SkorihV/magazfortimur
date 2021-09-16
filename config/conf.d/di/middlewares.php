<?php

use App\AuthMiddleware\AuthMiddleware;
use App\AuthMiddleware\CartMiddleware;
use App\AuthMiddleware\SharedData;

return [
    AuthMiddleware::class,
    CartMiddleware::class,
    SharedData::class,
];