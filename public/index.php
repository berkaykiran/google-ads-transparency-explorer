<?php
// Start the session for user management (if necessary)
session_start();

// Set internal character encoding to UTF-8
mb_internal_encoding('UTF-8');

// Include Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env file (if you use dotenv)
/*$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();*/

// Error reporting configuration
error_reporting(E_ALL);
//ini_set('display_errors', $_ENV['DISPLAY_ERRORS']);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

// Simple routing mechanism (you might want to use a framework or a routing library for complex applications)
$requestUrl = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUrl, PHP_URL_PATH);
switch ($path) {
    case '/':
    case '':
        $controller = new \Controller\HomeController(new \Model\CompetitorService());
        $controller->showHome();
        break;
    case '/ads':
        $controller = new \Controller\AdsController(new \Model\AdsModel(), new \Model\Region());
        $controller->showDashboard();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/../src/View/404.php';
        break;
}

// Clean up and flush the output buffer
ob_end_flush();
