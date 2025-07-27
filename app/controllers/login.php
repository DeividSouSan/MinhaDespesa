<?php

require_once "../app/models/user.php";

function login() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        login_user($_POST['email'], $_POST['password']);
        return;
    }

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        include "../app/pages/login.php";
        return;
    }

    http_response_code(405);
    header('Allow: GET POST');
    echo "Method not allowed\n";
    exit;
}
