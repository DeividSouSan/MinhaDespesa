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
        $password_hash = $user->password;

        try {
            $stmt = $this->database->prepare("
            INSERT INTO User (username, email, password_hash)
            VALUES (?,?,?);
            ");

            $stmt->bind_param("sss", $username, $email, $password_hash);

            $result = $stmt->execute();
        } catch (Exception $err) {
            echo $err;
        }
    }
}
