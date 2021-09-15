<?php

use App\AuthMiddleware\AuthMiddleware;
use App\AuthMiddleware\SharedData;

return [
    AuthMiddleware::class,
    SharedData::class,
];