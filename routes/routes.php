<?php

use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;

// Define routes
$app->get('/', [HomeController::class, 'index'], [AuthMiddleware::class]);
$app->get('/add', [HomeController::class, 'add']);