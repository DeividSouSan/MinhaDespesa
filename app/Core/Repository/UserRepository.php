<?php
interface UserRepositoryInterface
{
    public function add(User $user): void;
    public function activate(User $user): void;
    public function getByEmail(string $email): ?User;
    public function getByUsername(string $username): User | null;
    public function getByToken(string $token): User | null;
}
