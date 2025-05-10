<?php
require '../app/Infra/Database/database.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


match ($path) {
    '/' => require '../app/Presentation/View/home.php',
    '/home' => require '../app/Presentation/View/home.php',
    '/register' => require '../app/Presentation/View/register.php',
    '/register/confirm' => require '../app/Presentation/View/confirm-register.php',
    '/login' => require '../app/Presentation/View/login.php',
    '/logout' => require '../app/Presentation/View/logout.php',
    '/finances' => require '../app/Presentation/View/finances.php',
    default => require '../app/Presentation/View/404.php'
};
