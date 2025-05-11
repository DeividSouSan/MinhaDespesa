<?php

require '../app/Infra/DTO/_Exceptions.php';

class LoginUserDTO
{
    public readonly string $email;
    public readonly string $password;

    function __construct(string $email, string $password)
    {
        $is_missing_data = (empty($email) || empty($password));

        if ($is_missing_data) throw new MissingUserCredentials();

        $this->email = $email;
        $this->password = $password;
    }

    /**
     *  Cria um LoginUserDTO a partir de um array.
     *
     * @return LoginUserDTO
     */
    public static function fromArray(array $array): LoginUserDTO
    {
        return new LoginUserDTO(
            $array['email'] ?? '',
            $array['password'] ?? '',
        );
    }
}
