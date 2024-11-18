PHP/MVC
A PHP-based web application featuring a custom routing system, middleware, and models for database interaction. This project serves as a foundational framework for building scalable and modular PHP applications and backend Apis.

About the Project
This project is a custom PHP framework designed to simplify web application development.
It includes:

A basic routing system to handle different HTTP methods and URI paths.
Middleware support, allowing for actions (like authentication) to be applied to specific routes.
A Model class that connects to a MySQL database using MySQLi, which other models can extend to interact with specific tables.
Features
Routing: Supports GET, POST, PUT, and DELETE methods.
Middleware: Easily add middleware to handle request pre-processing, such as authentication.
Models: A core Model class for interacting with MySQL, with the option to extend it for custom models.
JWT Authentication: Generates and validates JSON Web Tokens for secure user authentication.
Session Management: Built-in session management for handling session data.
Prerequisites
PHP (version 8.0 or higher)
MySQL
Composer for dependency management (if using libraries like Firebase JWT)
