<?php

require '../app/Core/Repository/MailerService.php';

class MailNotSentException extends Exception
{
    public function __construct(string $message = '', int $code = 422)
    {
        parent::__construct($message, $code);
        $this->message = "O e-mail de confirmação não foi enviado.";
        $this->code = $code;
    }
};

class MailerService implements MailerServiceInterface
{
    /**
     * Envia um e-mail de confirmação ao e-mail do usuário.
     * @param User $user
     * @return void
     *
     * @throws MailNotSentException
     */
    static function sendConfirmationEmail(User $user): void
    {
        $to = $user->email;
        $subject = 'Confirmação de cadastro';
        $message = 'Clique no link para confirmar seu registro: http://localhost:8080/register/confirm?token=' . $user->token;
        $headers = 'From: test@dominio.com' . "\r\n" . 'Reply-To: test@dominio.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        $sent = mail($to, $subject, $message, $headers);
        if (!$sent) throw new MailNotSentException('Erro no Sistema: Não foi possível enviar o e-mail');
    }
}
