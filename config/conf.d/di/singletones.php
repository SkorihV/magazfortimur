<?php

use App\Data\Shop\Order\OrderRepository;
use App\Middleware\AuthMiddleware;
use App\Middleware\CartMiddleware;
use App\Http\Request;
use App\Http\Response;
use App\Middleware\SharedData;
use App\Model\ModelAnalyzer;
use App\Model\ModelManager;
use App\Renderer\Renderer;
use App\Utils\DocParser;
use App\Utils\StringUtil;
use App\Utils\ReflectionUtil;

return [
    ReflectionUtil::class,
    DocParser::class,
    StringUtil::class,

    Request::class,
    Response::class,
    Renderer::class,
    ModelManager::class,
    AuthMiddleware::class,
    CartMiddleware::class,
    SharedData::class,

    ModelAnalyzer::class,
    OrderRepository::class,

];