<?php
class PageNotFound extends Exception
{
    public string $name;
    public string $action;

    function __construct(string $path)
    {
        $this->name = "PageNotFound";
        $this->message = "Não existe nenhuma página acessível através de " . $path;
        $this->action = "Verifique se o caminho digitado existe ou está escrito errado.";
        $this->code = 404;

        parent::__construct($this->message, $this->code);
    }

    final public function getName() { return $this->name; }
    final public function getAction() { return $this->action; }
}

class DatabaseError extends Exception
{
    public string $name;
    public string $action;

    function __construct()
    {
        $this->name = "DatabaseError";
        $this->message = "Há problema no Banco de Dados ou na consulta.";
        $this->action = "Aguarde um momento, se o problema persistir entre em contato com o suporte.";
        $this->code = 503;

        parent::__construct($this->message, $this->code);
    }

    final public function getName() { return $this->name; }
    final public function getAction() { return $this->action; }
}

