<?php

require '../app/infra/user_repository.php';
require '../app/dto/create_user_dto.php';
require '../app/services/user_service.php';
require '../app/services/mailer_service.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $dto = new CreateUserDTO($_POST);

        $repository = new UserRepository();
        $mailer = new MailerService();

        $service = new UserService($repository, $mailer);
        $user = $service->createFromDTO($dto);
        $service->register($user);
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
    <title>Registre-se</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registre-se</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registre-se</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <main class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php if (isset($error_message)): ?>
                <section class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <?php echo $error_message ?>
                </section>
            <?php else: ?>
                <section class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    E-mail de confirmação enviado para <strong><?php echo $_POST['email'] ?></strong>
                </section>
            <?php endif ?>
        <?php endif ?>

        <form action="/register" method="POST" class="space-y-5">
            <h2 class="text-2xl font-bold text-gray-900">Registre-se</h2>
            <p class="text-sm text-gray-600">Cadastre-se agora para organizar suas finanças!</p>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Nome de Usuário</label>
                <input type="text" name="username" placeholder="Fulano Alguém"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email" placeholder="fulano@provedor.com"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" placeholder="Digite uma senha forte."
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <div>
                <label for="password-confirmation" class="block text-sm font-medium text-gray-700">Confirme a senha</label>
                <input type="password" name="password-confirmation" placeholder="Digite a senha novamente."
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <div>
                <input type="submit" value="Registrar-se"
                    class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md cursor-pointer transition" />
            </div>
            <div class="text-center text-sm text-gray-600 mt-4">
                Já tem uma conta?
                <a href="/login" class="text-indigo-600 hover:text-indigo-500 font-medium">Faça login!</a>
            </div>
        </form>
    </main>
</body>

</html>
