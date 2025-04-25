<?php

require '../app/infra/user_repository.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {
        $user = new UserDTO($_POST);
        $user->validate();

        $user_repository = new UserRepository();
        $user_repository->add($user);
    } catch (Exception $e) {
        $error_message = $e->getMessage();
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
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php if ($error_message): ?>
                <section class='error-section'>
                    <?php echo $error_message ?>
                </section>
            <?php else: ?>
                <section class='success-section'>
                    E-mail de confirmação enviado para <strong><?php echo $_POST['email'] ?></strong>
                </section>
            <?php endif ?>
        <?php endif ?>

        <section class="auth-form-wrapper">
            <form action="/register" method="POST">
                <h1>Registre-se</h1>
                <section class=' field-wrapper'>
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
