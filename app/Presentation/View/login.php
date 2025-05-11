<?php

require "../app/Infra/Database/UserRepository.php";

class EmailNotFound extends Exception
{
    public function __construct(string $message = '', int $code = 404)
    {
        parent::__construct($message, $code);
        $this->message = "O e-mail inserido não pertence a um usuário";
        $this->code = $code;
    }
};


class PasswordIncorrect extends Exception
{
    public function __construct(string $message = '', int $code = 404)
    {
        parent::__construct($message, $code);
        $this->message = "A senha inserida está errada";
        $this->code = $code;
    }
};

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $repository = new UserRepository();
        $db_user = $repository->getByEmail($email);

        if (!$db_user) throw new EmailNotFound();

        $match_password = password_verify($password, $db_user->password);
        if (!$match_password) throw new PasswordIncorrect();

        $_SESSION['email'] = $email;
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon"
        href="https://cdn.iconscout.com/icon/free/png-256/free-cash-icon-download-in-svg-png-gif-file-formats--money-currency-dollar-payment-bank-investing-and-finance-pack-business-icons-1746112.png"
        type="image/x-icon">
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">
    <main class="w-full max-w-md p-6 bg-white rounded-lg shadow-md mb-6">
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php if (isset($error_message)): ?>
                <section class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <?php echo $error_message ?>
                </section>
            <?php endif ?>
        <?php endif ?>

        <form action="/login" method="POST" class="space-y-5">
            <h2 class="text-2xl font-bold text-gray-900">Entrar</h2>
            <p class="text-sm text-gray-600">Acesse sua conta para gerenciar suas finanças.</p>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email" placeholder="fulano@provedor.com"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500" required />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" placeholder="Digite sua senha"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500" required />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Lembrar-me
                    </label>
                </div>
                <a href="/forgot-password" class="text-sm text-indigo-600 hover:text-indigo-500">Esqueceu a senha?</a>
            </div>

            <div>
                <input type="submit" value="Entrar"
                    class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md cursor-pointer transition" />
            </div>

            <div class="text-center text-sm text-gray-600 mt-4">
                Não tem uma conta?
                <a href="/register" class="text-indigo-600 hover:text-indigo-500 font-medium">Registre-se</a>
            </div>
        </form>
    </main>

    <footer class="text-center text-sm text-gray-500">
        Projeto pessoal desenvolvido por
        <a href="https://github.com/deividsousan" class="text-indigo-600 hover:text-indigo-500 font-medium">
            @deividsousan
        </a>
    </footer>
</body>

</html>
