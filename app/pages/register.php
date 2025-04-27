<?php

require '../app/infra/user_repository.php';
require '../app/dto/user_dto.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $uri == '/register') {
    try {
        $user_dto = new UserDTO($_POST);
        $user_dto->validate();


        $user = new User();
        $user->username = $user_dto->username;
        $user->email = $user_dto->email;
        $user->password = password_hash($user_dto->password, PASSWORD_BCRYPT);
        $user->token = bin2hex(random_bytes(16));

        $user_repository = new UserRepository();

        $databse_user = $user_repository->getByUsername($user->username);
        if ($databse_user) {
            throw new Exception('Nome de usuário já cadastrado');
        }

        $databse_user = $user_repository->getByEmail($user->email);
        if ($databse_user) {
            throw new Exception('E-mail já cadastrado');
        }

        $user_repository->add($user);

        $to = $user->email;
        $subject = 'Confirmação de registro';
        $message = 'Clique no link para confirmar seu registro: ' .
            'http://localhost:8080/register/confirm?token=' . $user->token;
        $headers = 'From: test@dominio.com' . "\r\n" .
            'Reply-To: test@dominio.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            echo "E-mail enviado com sucesso!";
        } else {
            echo "Falha no envio do e-mail.";
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $uri == '/register/confirm') {
    $token = $_GET['token'] ?? '';

    if (empty($token)) {
        $error_message = 'Token inválido';
    } else {
        $user_repository = new UserRepository();
        $user = $user_repository->getByToken($token);

        $user_repository->activate($user);
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
