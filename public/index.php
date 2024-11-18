<?php

// Bootstrap the application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Load the routes
require_once __DIR__ . '/../routes/routes.php';

$app->run();