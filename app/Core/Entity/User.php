<?php
class User
{
    public ?string $id;
    public string $username;
    public string $email;
    public string $password;
    public ?string $token;

    function __construct(string $username, string $email, string $password, ?string $id = null, ?string $token = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }

    static function fromArray(array $array)
    {
        return new User(
            $array['username'],
            $array['email'],
            $array['password_hash'],
            $array['id'] ?? null,
            $array['token'] ?? null
        );
    }
}
