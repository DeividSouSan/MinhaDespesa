<?php

require '../app/Infra/DTO/_Exceptions.php';

class CreateUserDTO
{
    public readonly string $username;
    public readonly string $email;
    public readonly string $password;
    public readonly string $password_confirmation;

    function __construct(string $username, string $email, string $password, string $password_confirmation)
    {
        $is_missing_data = (empty($username) || empty($email) || empty($password) || empty($password_confirmation));

        if ($is_missing_data) throw new MissingUserCredentials();

        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;

        $this->validate();
    }

    /**
     *  Cria um CreateUserDTO a partir de um array.
     *
     * @return CreateUserDTO
     */
    public static function fromArray(array $array): CreateUserDTO
    {
        return new CreateUserDTO(
            $array['username'] ?? '',
            $array['email'] ?? '',
            $array['password'] ?? '',
            $array['password-confirmation'] ?? '',
        );
    }

    /**
     *  Valida os dados do DTO.
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validate(): void
    {
        // e-mail
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) throw new ValidationException('e-mail', 'formato inválido');
        if (strlen($this->email) < 5) throw new ValidationException('e-mail', 'deve ter no mínimo 5 caracteres');
        if (strlen($this->email) > 50) throw new ValidationException('e-mail', 'deve ter no máximo 50 caracteres');

        // username
        if (strlen($this->username) < 3) throw new ValidationException('username', 'deve ter no mínimo 3 caracteres');
        if (strlen($this->username) > 20) throw new ValidationException('username', 'deve ter no máximo 20 caracteres');
        if (preg_match('/\s/', $this->username)) throw new ValidationException('username:', 'não pode conter espaços');

        // password
        if (strlen($this->password) < 8) throw new ValidationException('password', 'deve ter no mínimo 8 caracteres');
        if (!preg_match('/[A-Z]/', $this->password)) throw new ValidationException('password', 'deve conter pelo menos uma letra maiúscula');
        if (!preg_match('/[a-z]/', $this->password)) throw new ValidationException('password', 'deve conter pelo menos uma letra minúscula');
        if (!preg_match('/[0-9]/', $this->password)) throw new ValidationException('password', 'deve conter pelo menos um número');
        if (!preg_match('/[\W_]/', $this->password)) throw new ValidationException('password', 'deve conter pelo menos um caractere especial');
        if (preg_match('/\s/', $this->password)) throw new ValidationException('password', 'não pode conter espaços');
        if (strlen($this->password) > 100) throw new ValidationException('password', 'deve ter no máximo 100 caracteres');

        // password confirmation
        if ($this->password !== $this->password_confirmation) throw new ValidationException('password confirmation', 'as senhas não batem');
    }
}
