<?php
// Start the session for user management (if necessary)
session_start();

// Set internal character encoding to UTF-8
mb_internal_encoding('UTF-8');

// Include Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Error reporting configuration
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

// Include the dependency container
$container = require __DIR__ . '/../src/dependencies.php';

// Setup FastRoute
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['HomeController', 'showHome']);
    $r->addRoute('POST', '/ads', ['AdsController', 'showDashboard']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// Dispatch the request
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        require __DIR__ . '/../src/View/404.php';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo "Method Not Allowed. Allowed methods: " . implode(', ', $allowedMethods);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $controller = $container[$handler[0]]();  // Create controller using the dependency container
        call_user_func_array([$controller, $handler[1]], $vars);
        break;
}

// Clean up and flush the output buffer
ob_end_flush();
