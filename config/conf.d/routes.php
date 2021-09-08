<?php


use App\Category\CategoryController;
use App\Import\ImportController;
use App\Product\ProductController;
use App\Queue\QueueController;

return [
    '/products/list'            => [ProductController::class, 'list'],
    '/'                         => [ProductController::class, 'list'],
    '/products/edit'            => [ProductController::class, 'edit'],
    '/products/add'             => [ProductController::class, 'add'],
    '/products/delete'          => [ProductController::class, 'delete'],
    '/products/delete_image'    => [ProductController::class, 'deleteImage'],
    '/products/edit/{id}'       => [ProductController::class, 'edit'],
    '/products/{id}/edit'       => [ProductController::class, 'edit'],

    '/categories/list'          => [CategoryController::class, 'list'],
    '/categories/add'           => [CategoryController::class, 'add'],
    '/categories/edit'          => [CategoryController::class, 'edit'],
    '/categories/edit/{id}'     => [CategoryController::class, 'edit'],
    '/categories/view'          => [CategoryController::class, 'view'],
    '/categories/delete'        => [CategoryController::class, 'delete'],
    '/categories/view/{id}'     => [CategoryController::class, 'view'],
    '/categories/{id}/view'     => [CategoryController::class, 'view'],

    '/queue/list'               => [QueueController::class, 'list'],
    '/queue/run'                => [QueueController::class, 'run'],
    "/queue/delete"             => [QueueController::class, 'delete'],

    '/import/index'             => [ImportController::class, 'index'],
    '/import/upload'            => [ImportController::class, 'upload'],
    '/import/parsing'            => [ImportController::class, 'parsing'],
];