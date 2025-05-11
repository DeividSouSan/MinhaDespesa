<?php
class User
{
    public string $username;
    public string $email;
    public string $password;
    public ?string $token;

    function __construct(string $username, string $email, string $password, ?string $token)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }
}
