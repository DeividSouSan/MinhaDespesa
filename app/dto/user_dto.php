<?php
class UserDTO
{
    public $username;
    public $email;
    public $password;

    function __construct(array $array)
    {
        $this->username = $array['username'];
        $this->email = $array['email'];
        $this->password = $array['password'];
    }
}
