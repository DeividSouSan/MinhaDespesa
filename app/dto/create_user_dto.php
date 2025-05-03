<?php
class CreateUserDTO
{
    public string  $username;
    public string  $email;
    public string  $password;

    function __construct(array $array)
    {
        $username = $array['username'] ?? '';
        $email = $array['email'] ?? '';
        $password = $array['password'] ?? '';
        $password_confirmation = $array['password-confirmation'] ?? '';

        $is_missing_data = (empty($username) || empty($email) || empty($password) || empty($password_confirmation));

        if ($is_missing_data) throw new Exception('Missing user data');
        if ($password !== $password_confirmation) throw new Exception('Password confirmation does not match');

        $this->username = $array['username'];
        $this->email = $array['email'];
        $this->password = $array['password'];

        $this->validate();
    }

    /**
     *  Valida os dados do DTO.
     *
     * @return void
     *
     * @throws Exception
     */

    function validate(): void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) throw new Exception('Formato de e-mail inválido');
        if (strlen($this->email) < 5) throw new Exception('O e-mail deve ter no mínimo 5 caracteres');
        if (strlen($this->email) > 50) throw new Exception('O e-mail deve ter no máximo 50 caracteres');

        if (strlen($this->username) < 3) throw new Exception('O nome de usuário deve ter no mínimo 3 caracteres');
        if (strlen($this->username) > 20) throw new Exception('O nome de usuário deve ter no máximo 20 caracteres');
        if (preg_match('/\s/', $this->username)) throw new Exception('O nome de usuário não pode conter espaços');

        if (strlen($this->password) < 8) throw new Exception('A senha deve ter no mínimo 8 caracteres');
        if (!preg_match('/[A-Z]/', $this->password)) throw new Exception('A senha deve conter pelo menos uma letra maiúscula');
        if (!preg_match('/[a-z]/', $this->password)) throw new Exception('A senha deve conter pelo menos uma letra minúscula');
        if (!preg_match('/[0-9]/', $this->password)) throw new Exception('A senha deve conter pelo menos um número');
        if (!preg_match('/[\W_]/', $this->password)) throw new Exception('A senha deve conter pelo menos um caractere especial');
        if (preg_match('/\s/', $this->password)) throw new Exception('A senha não pode conter espaços');
        if (strlen($this->password) > 100) throw new Exception('A senha deve ter no máximo 100 caracteres');
    }
}
