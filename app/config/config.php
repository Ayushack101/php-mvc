<?php

// Database Configuration
define("DB_HOST", value: $_ENV["DB_HOST"]);
define("DB_DATABASE", $_ENV["DB_DATABASE"]);
define("DB_USER", $_ENV["DB_USERNAME"]);
define("DB_PASS", $_ENV["DB_PASSWORD"]);

// JWT Secret Key
define("JWT_SECRET_KEY", $_ENV["JWT_SECRET_KEY"]);
define('JWT_EXPIRATION_TIME', $_ENV["JWT_EXPIRATION_TIME"]); // Token expiration time in seconds
define('JWT_ISSUER', $_ENV["JWT_ISSUER"]);
define('JWT_AUDIENCE', $_ENV["JWT_AUDIENCE"]);

// Base URL
define("BASE_URL", $_ENV["BASE_URL"]);

// Email Configurations
define("EMAIL_HOST", $_ENV["EMAIL_HOST"]);
define("EMAIL_PORT", $_ENV["EMAIL_PORT"]);
define("EMAIL_USER", $_ENV["EMAIL_USER"]);
define("EMAIL_PASS", $_ENV["EMAIL_PASS"]);

// Other Configurations
define("UPLOADS_DIR", "uploads/");
