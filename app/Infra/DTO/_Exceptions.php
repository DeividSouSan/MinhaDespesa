<?php
class MissingUserCredentials extends Exception
{
    public function __construct()
    {
        parent::__construct("Faltam dados do usuário");
    }
};

class ValidationException extends Exception
{
    protected string $field;

    public function __construct(string $field, string $message = "")
    {
        $this->field = $field;
        $fullMessage = "Erro: campo '{$field}' {$message}";
        parent::__construct($fullMessage);
    }
}
