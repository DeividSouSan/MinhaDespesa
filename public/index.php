<?php
require '../app/infra/database.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


match ($path) {
    '/' => require '../app/pages/home.php',
    '/home' => require '../app/pages/home.php',
    '/register' => require '../app/pages/register.php',
    '/register/confirm' => require '../app/pages/confirm-register.php',
    '/login' => require '../app/pages/login.php',
    '/logout' => require '../app/pages/logout.php',
    '/finances' => require '../app/pages/finances.php',
    default => require '../app/pages/404.php'
};
