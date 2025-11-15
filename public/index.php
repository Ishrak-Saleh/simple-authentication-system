<?php
declare(strict_types=1);

// autoload
require __DIR__ . '/../vendor/autoload.php';

// tiny .env loader (reads .env into getenv and $_ENV)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        [$key, $val] = array_map('trim', explode('=', $line, 2) + [1=>null]);
        if ($key && $val !== null) {
            putenv("$key=$val");
            $_ENV[$key] = $val;
        }
    }
}

use app\Core\Router;
use app\Core\Session;
use app\Controllers\AuthController;
use app\Controllers\DashboardController;
use app\Controllers\FeedController;
use app\Controllers\ProfileController; // ADD THIS LINE

Session::start();

$router = new Router();
$auth = new AuthController();
$dash = new DashboardController();

$router->get('/', fn() => $auth->showLogin());
$router->get('/login', fn() => $auth->showLogin());
$router->get('/register', fn() => $auth->showRegister());
$router->get('/dashboard', fn() => $dash->index());

$router->post('/register', fn() => $auth->register());
$router->post('/login', fn() => $auth->login());
$router->get('/logout', fn() => $auth->logout());

// Feed routes
$router->get('/feed', [FeedController::class, 'index']);
$router->post('/feed/post', [FeedController::class, 'createPost']);
$router->post('/feed/delete', [FeedController::class, 'deletePost']);
$router->get('/feed/edit', [FeedController::class, 'showEditPost']);
$router->post('/feed/update', [FeedController::class, 'updatePost']);
$router->post('/feed/like', [FeedController::class, 'likePost']);
$router->post('/feed/unlike', [FeedController::class, 'unlikePost']);
$router->post('/theme/toggle', [FeedController::class, 'toggleTheme']);

// Profile routes
$router->get('/profile', [ProfileController::class, 'showProfile']);
$router->post('/profile/picture/update', [ProfileController::class, 'updateProfilePicture']);
$router->post('/profile/picture/remove', [ProfileController::class, 'removeProfilePicture']);

$router->dispatch($_SERVER['REQUEST_URI'] ?? '/', $_SERVER['REQUEST_METHOD'] ?? 'GET');