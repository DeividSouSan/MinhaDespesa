<?php
class LoginUserDTO
{
    public string $email;
    public string $password;

    function __construct(string $email, string $password)
    {
        $is_missing_data = (empty($email) || empty($password));

        if ($is_missing_data) throw new Exception('Faltam informações do usuário!');

        $this->email = $email;
        $this->password = $password;
    }

    public static function fromArray(array $array): LoginUserDTO
    {
        return new LoginUserDTO(
            $array['email'],
            $array['password'],
        );
    }
}
