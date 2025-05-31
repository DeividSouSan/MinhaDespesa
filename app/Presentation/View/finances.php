<?php

require '../app/Infra/Database/TransactionRepository.php';
require '../app/Infra/DTO/CreateTransactionDTO.php';
require '../app/Presentation/Presenter/TransactionPresenter.php';

enum CategoryIcon: string
{
    case Salario = '💰';
    case RendaExtra = '🤑';
    case RendaPassiva = '📈';
    case Moradia = '🏠';
    case Alimentacao = '🥪';
    case Transporte = '🚌';
    case Viagens = '✈';
    case Saude = '🏥';
    case Educacao = '🎓';
    case Compras = '🛍';
    case Vestuario = '👕';
    case Lazer = '🧘‍♂️';
}

$transactionRepository = new TransactionRepository();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MinhaDespesa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon"
        href="https://cdn.iconscout.com/icon/free/png-256/free-cash-icon-download-in-svg-png-gif-file-formats--money-currency-dollar-payment-bank-investing-and-finance-pack-business-icons-1746112.png"
        type="image/x-icon">
</head>

<body class="bg-light min-vh-100">
    <?php include '../app/Presentation/View/Components/auth-header.php'; ?>

    <div class="container-fluid d-flex justify-content-center py-4">
        <main class="w-100 bg-white rounded shadow-lg p-4" style="max-width: 1200px;">
            <div class="row g-4">
                <!-- FORMULÁRIO -->
                <section class="col-md-6">
                    <form action="/finances" method="GET" class="mb-3">
                        <label class="form-label fw-semibold">Tipo (💰/💸)</label>
                        <select name="type" onchange="this.form.submit()" class="form-select">
                            <option value="despesa" <?php echo !isset($_GET['type']) || $_GET['type'] == 'despesa' ? 'selected' : ''; ?>>🔴 Despesa</option>
                            <option value="receita" <?php echo isset($_GET['type']) && $_GET['type'] == 'receita' ? 'selected' : ''; ?>>🟢 Receita</option>
                        </select>
                    </form>

                    <form action="/finances" method="POST">
                        <input type="hidden" name="type" value="<?php echo $_GET['type'] ?? 'despesa'; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">💵 Valor (R$)</label>
                            <input type="number" name="value" placeholder="0,00" step="any" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">📂 Categoria</label>
                            <select name="category" class="form-select">
                                <?php if ($_GET['type'] == 'receita'): ?>
                                    <option value="<?php echo CategoryIcon::Salario->value; ?>">💰 Salário</option>
                                    <option value="<?php echo CategoryIcon::RendaExtra->value; ?>">🤑 Renda Extra</option>
                                    <option value="<?php echo CategoryIcon::RendaPassiva->value; ?>">📈 Renda Passiva</option>
                                <?php else: ?>
                                    <option value="<?php echo CategoryIcon::Moradia->value; ?>">🏠 Moradia</option>
                                    <option value="<?php echo CategoryIcon::Alimentacao->value; ?>">🍔 Alimentação</option>
                                    <option value="<?php echo CategoryIcon::Transporte->value; ?>">🚌 Transporte</option>
                                    <option value="<?php echo CategoryIcon::Viagens->value; ?>">✈️ Viagens</option>
                                    <option value="<?php echo CategoryIcon::Saude->value; ?>">🏥 Saúde</option>
                                    <option value="<?php echo CategoryIcon::Educacao->value; ?>">📚 Educação</option>
                                    <option value="<?php echo CategoryIcon::Compras->value; ?>">📦 Compras</option>
                                    <option value="<?php echo CategoryIcon::Vestuario->value; ?>">👕 Vestuário</option>
                                    <option value="<?php echo CategoryIcon::Lazer->value; ?>">🎉 Lazer</option>
                                <?php endif ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">📅 Data</label>
                            <input type="date" name="date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">📝 Descrição</label>
                            <textarea name="description" rows="3" class="form-control"
                                placeholder="Adicione detalhes sobre a transação"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            Adicionar ➕
                        </button>
                    </form>

                    <?php if (isset($_SESSION['missing-value']) && $_SESSION['missing-value']): ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Faltando valores!!!
                        </div>
                    <?php endif ?>
                </section>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == 'POST') {
                    if (empty($_POST['value']) || empty($_POST['category']) || empty($_POST['date']) || empty($_POST['description'])) {
                        $_SESSION['missing-value'] = true;
                    } else {
                        $_SESSION['missing-value'] = false;

                        $transaction = new TransactionDTO($_POST);

                        $transactionRepository->add($transaction);
                    }
                }
                ?>

                <!-- LISTA DE TRANSAÇÕES -->
                <section class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr class="text-muted border-bottom">
                                    <th scope="col" class="py-2">Cat</th>
                                    <th scope="col" class="py-2">Valor</th>
                                    <th scope="col" class="py-2">Descrição</th>
                                    <th scope="col" class="py-2">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactionRepository->read() as $transaction): ?>
                                    <?php
                                    $transaction = new TransactionPresenter(
                                        $transaction['value'],
                                        $transaction['category'],
                                        $transaction['date'],
                                        $transaction['description'],
                                        $transaction['type']
                                    );
                                    $rowClass = $transaction->type === 'receita' ? 'table-success' : 'table-warning';
                                    ?>
                                    <tr class="<?php echo $rowClass; ?> border-bottom">
                                        <td class="py-2 px-2"><?php echo $transaction->category; ?></td>
                                        <td class="py-2 px-2 fw-semibold text-dark">R$ <?php echo $transaction->value; ?></td>
                                        <td class="py-2 px-2 text-truncate" style="max-width: 150px;"><?php echo $transaction->description; ?></td>
                                        <td class="py-2 px-2 text-muted"><?php echo $transaction->date; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <footer class="text-center mt-4">
        <small class="text-muted">
            Projeto pessoal desenvolvido por
            <a href="https://github.com/deividsousan" class="text-decoration-none fw-medium">
                @deividsousan
            </a>
        </small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
