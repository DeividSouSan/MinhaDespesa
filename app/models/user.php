<?php

function create_user($username, $email, $password) {
    db_query("
    INSERT INTO
        Users(username, email, password)
    VALUES
        (?, ?, ?)
    ", [$username, $email, $password], 'sss');
}

function login_user($email, $password) {
    session
}
?>
