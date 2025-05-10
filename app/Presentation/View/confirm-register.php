<?php

require "../app/Infra/Database/UserRepository.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $token = $_GET['token'] ?? '';

    if (empty($token)) {
        $valid_token = false;
    } else {
        $user_repository = new UserRepository();
        $user = $user_repository->getByToken($token);

        if (!is_null($user)) {
            $user_repository->activate($user);
            $valid_token = true;
        } else {
            $valid_token = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre-se</title>
</head>

<body>
    <main>
        <section>
            <?php if ($valid_token): ?>
                Usuário ativado com sucesso.
            <?php else: ?>
                Token inválido. Usuário não foi ativado.
            <?php endif ?>
        </section>


    </main>
    </section>
</body>

</html>
