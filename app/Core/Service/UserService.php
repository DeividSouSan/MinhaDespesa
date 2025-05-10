<?php

class UsernameAlreadyExistsException extends Exception
{
    public function __construct(string $message = '', int $code = 422)
    {
        parent::__construct($message, $code);
        $this->message = "O nome de usuário escolhido já está em uso";
        $this->code = $code;
    }
};

class EmailAlreadyExistsException extends Exception
{
    public function __construct(string $message = '', int $code = 422)
    {
        parent::__construct($message, $code);
        $this->message = "O e-mail inserido já está em uso";
        $this->code = $code;
    }
};



class UserService
{
    private UserRepositoryInterface $repository;
    private MailerServiceInterface $mailer;

    public function __construct(
        UserRepositoryInterface $repository,
        MailerServiceInterface $mailer
    ) {
        $this->repository = $repository;
        $this->mailer = $mailer;
    }

    /**
     *  Registra um usuário no banco de dados e envia o e-mail de confirmação.
     *
     * @param User $user
     * @return void
     *
     * @throws UsernameAlreadyExistsException
     * @throws EmailAlreadyExistsException
     */
    public function register(User $user): void
    {
        if ($this->repository->getByUsername($user->username)) throw new UsernameAlreadyExistsException();
        if ($this->repository->getByEmail($user->email)) throw new EmailAlreadyExistsException();

        $this->repository->add($user);
        $this->mailer::sendConfirmationEmail($user);
    }

    /**
     * Cria um User a partir de um DTO validado.
     *
     * @param CreateUserDTO $dto
     * @return User
     */
    public function createFromDTO(CreateUserDTO $dto): User
    {
        $user = new User();
        $user->username = $dto->username;
        $user->email = $dto->email;
        $user->password = password_hash($dto->password, PASSWORD_BCRYPT);
        $user->token = bin2hex(random_bytes(16));

        return $user;
    }
}
