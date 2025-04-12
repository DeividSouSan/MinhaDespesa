<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] || '';
    $email = $_POST['email'] || '';
    $password = $_POST['password'] || '';
    $password_confirmation = $_POST['password-confirmation'] || '';

    $missing_data = (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password-confirmation']));

    if (!$missing_data) {
        echo 'Informações salvas no bd!!!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre-se</title>
    <link rel="stylesheet" href="main.css">

</head>

<body>
    <main>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $missing_data): ?>
            <section>
                Informações estão faltando.
            </section>
        <?php endif ?>
        <section class="auth-form-wrapper">
            <form action="/register" method="POST">
                <h1>Registre-se</h1>
                <section class='field-wrapper'>
                    <label for="username" class="username">Nome de Usuário</label>
                    <input type="text" name="username" placeholder="Fulano Alguém">
                </section>
                <section class='field-wrapper'>
                    <label for="email" class='email'>E-mail</label>
                    <input type="email" name="email" placeholder="fulano@provedor.com">
                </section>
                <section class='field-wrapper'>
                    <label for="password" class='password'>Senha</label>
                    <input type="password" name="password" placeholder="Digite uma senha forte.">
                </section>
                <section class='field-wrapper'>
                    <label for="password-confirmation" class='password-confirmation'>Confirme a senha</label>
                    <input type="password" name="password-confirmation" placeholder="Digite a senha novamente.">
                </section>

                <section class="field-wrapper"><input type="submit" value="Registrar-se"></section>
            </form>
    </main>

    </section>
</body>

</html>
