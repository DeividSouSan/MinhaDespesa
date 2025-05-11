<?php

require '../app/Infra/Database/UserRepository.php';
require '../app/Infra/DTO/CreateUserDTO.php';
require '../app/Core/Service/UserService.php';
require '../app/Core/Service/MailerService.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $dto = CreateUserDTO::fromArray($_POST);

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
    <title>Cadastro - MinhaDespesa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="shortcut icon"
        href="https://cdn.iconscout.com/icon/free/png-256/free-cash-icon-download-in-svg-png-gif-file-formats--money-currency-dollar-payment-bank-investing-and-finance-pack-business-icons-1746112.png"
        type="image/x-icon">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .register-form-container {
            max-width: 450px;
            width: 100%;
        }
    </style>
</head>

<body>
    <main class="register-form-container p-4 bg-white rounded-3 shadow-sm">
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php if (isset($error_message)): ?>
                <section class="alert alert-danger p-3 mb-4 rounded alert-dismissible fade show">
                    <?php echo htmlspecialchars($error_message); ?>
                    <button type='button' class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </section>
            <?php else: ?>
                <section class="alert alert-success p-3 mb-4 rounded alert-dismissible show">
                    E-mail de confirmação enviado para <strong><?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?></strong>
                    <button type='button' class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </section>
            <?php endif; ?>
        <?php endif; ?>

        <form action="/register" method="POST">
            <h2 class="h2 fw-bold text-dark mb-2">Registre-se</h2>
            <p class="small text-muted mb-4">Cadastre-se agora para organizar suas finanças!</p>

            <div class="mb-3">
                <label for="username" class="form-label">Nome de Usuário</label>
                <input type="text" name="username" id="username" placeholder="Fulano Alguém"
                    class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" placeholder="fulano@provedor.com"
                    class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" placeholder="Digite uma senha forte."
                    class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="password-confirmation" class="form-label">Confirme a senha</label>
                <input type="password" name="password-confirmation" id="password-confirmation" placeholder="Digite a senha novamente."
                    class="form-control" required />
            </div>

            <div class="mb-3">
                <input type="submit" value="Registrar-se"
                    class="btn btn-primary w-100 py-2 fw-semibold" />
            </div>
            <div class="text-center small text-muted mt-4">
                Já tem uma conta?
                <a href="/login" class="text-primary fw-medium text-decoration-none">Faça login!</a>
            </div>
        </form>
    </main>

    <!-- Optional: Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>
