<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <main class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
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
</body>

</html>
