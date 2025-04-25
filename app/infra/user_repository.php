<?php

require '../app/dto/user_dto.php';

class UserRepository
{
    private mysqli $database;

    function __construct()
    {
        $this->database = require '../app/infra/database.php';
    }

    function add(UserDTO $user)
    {
        $username = $user->username;
        $email = $user->email;
        $password_hash = password_hash($user->password, PASSWORD_BCRYPT);

        $stmt = $this->database->prepare("
        INSERT INTO User (username, email, password_hash)
        VALUES (?,?,?);
        ");

        $stmt->bind_param("sss", $username, $email, $password_hash);

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
}
