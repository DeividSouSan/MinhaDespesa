<?php

require "../app/Infra/Database/UserRepository.php";
require "../app/Infra/DTO/LoginUserDTO.php";

class EmailNotFound extends Exception
{
    public function __construct(string $message = '', int $code = 404)
    {
        parent::__construct($message, $code);
        $this->message = "E-mail não cadastrado. Crie uma conta.";
        $this->code = $code;
    }
};


class PasswordIncorrect extends Exception
{
    public function __construct(string $message = '', int $code = 404)
    {
        parent::__construct($message, $code);
        $this->message = "Senha incorreta";
        $this->code = $code;
    }
};

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $dto = LoginUserDTO::fromArray($_POST);

        $repository = new UserRepository(); // se fosse injetado não precisa instanciar toda vez
        $db_user = $repository->getByEmail($dto->email);

        if ($db_user == null) throw new EmailNotFound();

        $match_password = password_verify($dto->password, $db_user->password);
        if (!$match_password) throw new PasswordIncorrect();

        $_SESSION['UID'] = $db_user->id;
        header('Location: /finances');
    } catch (Exception $error) {
        $error_message = $error->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MinhaDespesa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="shortcut icon"
        href="https://cdn.iconscout.com/icon/free/png-256/free-cash-icon-download-in-svg-png-gif-file-formats--money-currency-dollar-payment-bank-investing-and-finance-pack-business-icons-1746112.png"
        type="image/x-icon">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .login-form-container {
            max-width: 450px;
        }
    </style>
</head>

<body class="p-4">
    <main class="w-100 login-form-container p-4 bg-white rounded-3 shadow-sm mb-5">
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php if (isset($error_message)): ?>
                <section class="alert alert-danger p-3 mb-4 rounded alert-dismissible fade show" role='alert'>
                    <?php echo htmlspecialchars($error_message) ?>
                    <button type='button' class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </section>
            <?php endif ?>
        <?php endif ?>

        <form action="/login" method="POST" id='login-form'>
            <h2 class="h2 fw-bold text-dark mb-2">Entrar</h2>
            <p class="small text-muted mb-4">Acesse sua conta para gerenciar suas finanças.</p>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" placeholder="fulano@provedor.com"
                    class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" placeholder="Digite sua senha"
                    class="form-control" required />
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="form-check">
                    <input id="remember" name="remember" type="checkbox" class="form-check-input">
                    <label for="remember" class="form-check-label small text-secondary">
                        Lembrar-me
                    </label>
                </div>
                <a href="/forgot-password" class="small text-primary text-decoration-none">Esqueceu a senha?</a>
            </div>

            <div class="mb-3">
                <input type="submit" value="🔒"
                    class="btn btn-primary w-100 py-2 fw-semibold" id='submit-button' disabled/>
            </div>

            <div class="text-center small text-muted mt-4">
                Não tem uma conta?
                <a href="/register" class="text-primary fw-medium text-decoration-none">Registre-se</a>
            </div>
        </form>
    </main>

    <footer class="text-center small text-muted">
        Projeto pessoal desenvolvido por
        <a href="https://github.com/deividsousan" class="text-primary fw-medium text-decoration-none">
            @deividsousan
        </a>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    <script>
        const registerForm = document.querySelector("#login-form");
        const emailInput = document.querySelector('#email');
        const passwordInput = document.querySelector('#password');
        const submitButton = document.querySelector('#submit-button');

        const isFilled = (inputElement) => {
            if (inputElement.value.length > 0) {
                return true;
            } else {
                return false;
            }
        }

        const fields = [emailInput, passwordInput];

        registerForm.addEventListener('keyup', (event) => {
            const allFieldsFilled = fields.every(isFilled);
            console.log(allFieldsFilled);

            if (allFieldsFilled) {
                submitButton.value = '🔓 ENTRAR';
                submitButton.disabled = false;
            } else {
                submitButton.value = '🔒';
                submitButton.disabled = true;
            }
        });
    </script>

</body>

</html>
