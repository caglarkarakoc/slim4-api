<?php

use Noodlehaus\Config;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Dotenv\Exception\InvalidPathException;
use Illuminate\Database\Capsule\Manager;

require __DIR__ . '/../vendor/autoload.php';

// Env
try {
    $dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
    $dotenv->load();
} catch (InvalidPathException $e) {
    die($e);
}

// Load Database Config
$database = new Config(
    base_path('config/Database.php')
);

// PHP-DI Container instance
$containerBuilder = new ContainerBuilder();

// Load Settings
$settings = require __DIR__ . '/../config/Settings.php';
$settings($containerBuilder);

// Load Dependencies
$dependencies = require __DIR__ .'/../config/Dependencies.php';
$dependencies($containerBuilder);

// Container Build
$container = $containerBuilder->build();

// Create App
AppFactory::setContainer($container);
$app = AppFactory::create();

$displayErrorDetails = $container->get('settings')['displayErrorDetails'];

// Eloquent
$capsule = new Manager;
$capsule->addConnection($database->get('db'));
$capsule->bootEloquent();
$capsule->setAsGlobal();

// Load Middleware
$middleware = require __DIR__ . '/../config/Middleware.php';
$middleware($app);

// Load Routes
$routes = require __DIR__ . '/../config/Routes.php';
$routes($app);

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Routing Middleware
$app->addRoutingMiddleware();

// Custom Error Handler
$customErrorHandler = require __DIR__ . '/../config/ErrorHandler.php';

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

return $app;