<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/.env'; // Load env
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Middleware.php';
require_once __DIR__ . '/../app/Core/Logger.php';
require_once __DIR__ . '/../app/Core/Language.php';

use App\Core\Database;
use App\Core\Router;
use App\Core\Logger;
use App\Core\Language;
use App\Core\User;

try {
    $db = Database::getInstance()->getConnection();
    $router = new Router();

    // Routes (full list from previous)
    $router->add('GET', '/login', [new App\Controllers\AuthController($db), 'login']);
    $router->add('POST', '/login', [new App\Controllers\AuthController($db), 'login']);
    $router->add('GET', '/logout', [new App\Controllers\AuthController($db), 'logout']);
    $router->add('GET', '/register', [new App\Controllers\AuthController($db), 'register']);
    $router->add('POST', '/register', [new App\Controllers\AuthController($db), 'register']);
    $router->add('GET', '/dashboard', [new App\Controllers\UserController($db), 'dashboard']);
    $router->add('GET', '/admin/users', [new App\Controllers\AdminController($db), 'manageUsers']);
    $router->add('GET', '/admin/edit/{id}', [new App\Controllers\AdminController($db), 'editUser']);
    $router->add('POST', '/admin/edit/{id}', [new App\Controllers\AdminController($db), 'editUser']);
    $router->add('GET', '/admin/delete/{id}', [new App\Controllers\AdminController($db), 'deleteUser']);
    $router->add('GET', '/accountant/transactions', [new App\Controllers\AccountantController($db), 'manageTransactions']);
    $router->add('POST', '/accountant/add-transaction', [new App\Controllers\AccountantController($db), 'addTransaction']);
    $router->add('POST', '/accountant/generate-invoice', [new App\Controllers\AccountantController($db), 'generateInvoice']);
    $router->add('GET', '/user/profile', [new App\Controllers\UserController($db), 'dashboard']);
    $router->add('POST', '/user/upload', [new App\Controllers\UserController($db), 'uploadDocument']);
    $router->add('GET', '/api/transactions', [new App\Controllers\ApiController($db), 'getTransactions']);
    $router->add('GET', '/search', [new App\Controllers\ApiController($db), 'search']); // Added for search/filtering

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    $router->dispatch($method, $uri);
} catch (Exception $e) {
    Logger::error($e->getMessage());
    include __DIR__ . '/../app/Views/error.html';
}