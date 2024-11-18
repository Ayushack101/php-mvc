<?php

// Autoload Dependencies
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;
use Dotenv\Dotenv;

// Load Environment Variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Start Session
session_start();

// Initialize Application
$app = new Application();

return $app;