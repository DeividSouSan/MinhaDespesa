<?php
interface UserRepositoryInterface
{
    private mysqli $database;

    function add(User $user): void;
    function activate(User $user): void;
    function getByEmail(string $email): User | null;
    function getByUsername(string $username): User | null;
    function getByToken(string $token): User | null;
}
