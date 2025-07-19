<?php
require_once '../app/controllers/status.php';
require_once '../app/controllers/users.php';
require_once '../app/errors.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
try {
    match ($path) {
        '/status' => status(),
        '/users' => users(),
        default => throw new PageNotFound($path)
    };
} catch (Exception $error) {
    include "../app/pages/error.php";
};
