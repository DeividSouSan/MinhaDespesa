<?php
require_once '../app/controllers/status.php';
require_once '../app/controllers/register.php';
require_once '../app/controllers/login.php';
require_once '../app/errors.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
try {
    match ($path) {
        '/status' => status(),
        '/register' => register(),
        '/login' => login(),
        default => throw new PageNotFound($path)
    };
} catch (Exception $error) {
    include "../app/pages/error.php";
};
