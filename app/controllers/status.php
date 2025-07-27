<?php
require_once "../app/database.php";

// controller básico do /status
function status() {
    if ($_SERVER['REQUEST_METHOD'] !== "GET") {
        http_response_code(405);
        header('Allow: GET');
        echo "Method not allowed\n";
        exit;
    }

    $active_connections = db_query("
    SHOW
        status
    WHERE
        variable_name = 'Threads_connected'
    ;")->fetch_all()[0][1];

    $max_connections = db_query("
    SHOW
        variables
    LIKE
        'max_connections'
    ;")->fetch_all()[0][1];

    $database_version = db_query("
    SHOW
        variables
    LIKE
        'version';")->fetch_all()[0][1];

    include "../app/pages/status.php";
}
