<?php

include "../app/models/user.php";

function users() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        create_user($_POST['username'], $_POST['email'], $_POST['password']);
        return;
    }

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        include "../app/pages/register.php";
        return;
    }

    http_response_code(405);
    header('Allow: GET POST');
    echo "Method not allowed\n";
    exit;
}
