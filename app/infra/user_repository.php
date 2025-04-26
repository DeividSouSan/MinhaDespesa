<?php

require '../app/infra/user.php';

class UserRepository
{
    private mysqli $database;

    function __construct()
    {
        $this->database = require '../app/infra/database.php';
    }

    function add(User $user)
    {
        $username = $user->username;
        $email = $user->email;
        $password_hash = $user->password;
        $token = $user->token;

        $stmt = $this->database->prepare("
        INSERT INTO User (username, email, password_hash, token)
        VALUES (?,?,?,?);
        ");

        $stmt->bind_param("ssss", $username, $email, $password_hash, $token);

        $result = $stmt->execute();
    }

    function getByEmail(string $email)
    {
        $stmt = $this->database->prepare("
        SELECT * FROM User WHERE email = ?;
        ");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    function getByUsername(string $username)
    {
        $stmt = $this->database->prepare("
        SELECT * FROM User WHERE username = ?;
        ");

        $stmt->bind_param("s", $username);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    function getByToken(string $token): User
    {
        $stmt = $this->database->prepare("
        SELECT * FROM User WHERE token = ?;
        ");

        $stmt->bind_param("s", $token);

        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        $user = new User();

        $user->username = $row['username'];
        $user->email = $row['email'];
        $user->password = $row['password_hash'];
        $user->token = $row['token'];

        return $user;
    }

    function activate(User $user)
    {
        $stmt = $this->database->prepare("
        UPDATE User SET token = NULL WHERE token = ?;
        ");

        $stmt->bind_param("s", $user->token);

        $stmt->execute();
    }
}
