<?php
require '../app/Infra/Database/database.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

session_start();

$not_in_session = !isset($_SESSION['email']);
$need_auth = in_array($path, ['/finances']);

if ($not_in_session and $need_auth) {
    header('Location: /login');
} // quebrado

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
