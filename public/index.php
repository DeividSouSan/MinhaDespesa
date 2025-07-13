<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

session_start();
$user_is_logged = !empty($_SESSION['UID']);

$public_routes = ['/', '/home', '/login', '/register', '/register/confirm'];
$private_routes = ['/finances'];

// user_in_public_route and user_is_logged -> private_route
// user_in_public_route and user_is_not_logged -> skip
// user_in_private_route and user_is_logged -> skip
// user_in_private_route and user_is_not_logged -> public_route

if (in_array($path, $public_routes) && $user_is_logged) {
    header('Location: /finances');
} else if (in_array($path, $private_routes) && !$user_is_logged) {
    header('Location: /home');
}

match ($path) {
    '/' => require '../app/Presentation/View/home.php',
    '/home' => require '../app/Presentation/View/home.php',
    '/register' => require '../app/Presentation/View/register.php',
    '/register/confirm' => require '../app/Presentation/View/confirm-register.php',
    '/login' => require '../app/Presentation/View/login.php',
    '/logout' => require '../app/Presentation/View/logout.php',
    '/finances' => require '../app/Presentation/View/finances.php',
    '/status' => require '../app/Presentation/View/status.php',
    default => require '../app/Presentation/View/404.php'
};
