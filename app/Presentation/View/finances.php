<?php

require '../app/Infra/Database/TransactionRepository.php';
require '../app/Infra/DTO/CreateTransactionDTO.php';
require '../app/Presentation/Presenter/TransactionPresenter.php';

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: /login');
}

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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon"
        href="https://cdn.iconscout.com/icon/free/png-256/free-cash-icon-download-in-svg-png-gif-file-formats--money-currency-dollar-payment-bank-investing-and-finance-pack-business-icons-1746112.png"
        type="image/x-icon">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4">
    <main class="w-full max-w-8xl bg-white rounded-xl shadow-lg p-6 flex flex-col md:flex-row gap-6">

        <!-- FORMULÁRIO -->
        <section class="w-full md:w-1/2 space-y-4">
            <form action="/finances" method="GET">
                <label class="block text-sm font-semibold">Tipo (💰/💸)</label>
                <select name="type" onchange="this.form.submit()"
                    class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2">
                    <option value="despesa" <?php echo !isset($_GET['type']) || $_GET['type'] == 'despesa' ? 'selected' : ''; ?>>🔴
                        Despesa</option>
                    <option value="receita" <?php echo isset($_GET['type']) && $_GET['type'] == 'receita' ? 'selected' : ''; ?>>🟢
                        Receita</option>
                </select>
            </form>

            <form action="/finances" method="POST" class="space-y-4">
                <input type="hidden" name="type" value="<?php echo $_GET['type'] ?? 'despesa'; ?>">

                <div>
                    <label class="block text-sm font-semibold">💵 Valor (R$)</label>
                    <input type="number" name="value" placeholder="0,00" step="any"
                        class="w-full mt-1 px-3 py-2 rounded-md border border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-semibold">📂 Categoria</label>
                    <select name="category" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2">
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

                <div>
                    <label class="block text-sm font-semibold">📅 Data</label>
                    <input type="date" name="date" class="w-full mt-1 px-3 py-2 rounded-md border border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-semibold">📝 Descrição</label>
                    <textarea name="description" rows="3"
                        class="w-full mt-1 px-3 py-2 rounded-md border border-gray-300 resize-none placeholder:text-sm"
                        placeholder="Adicione detalhes sobre a transação"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-fuchsia-600 text-white py-2 rounded-md font-semibold hover:bg-fuchsia-700 transition">
                    Adicionar ➕
                </button>
            </form>

            <?php if (isset($_SESSION['missing-value']) && $_SESSION['missing-value']): ?>
                <div class="text-red-600 text-sm bg-red-100 p-2 rounded">Faltando valores!!!</div>
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
        <section class="w-full md:w-1/2">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-600 border-b">
                        <th class="py-2">Cat</th>
                        <th class="py-2">Valor</th>
                        <th class="py-2">Descrição</th>
                        <th class="py-2">Data</th>
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
                        $rowClass = $transaction->type === 'receita' ? 'bg-green-50' : 'bg-yellow-50';
                        ?>
                        <tr class="<?php echo $rowClass; ?> border-b">
                            <td class="py-2 px-1"><?php echo $transaction->category; ?></td>
                            <td class="py-2 px-1 font-semibold text-gray-700">R$ <?php echo $transaction->value; ?></td>
                            <td class="py-2 px-1 truncate max-w-xs"><?php echo $transaction->description; ?></td>
                            <td class="py-2 px-1 text-gray-500"><?php echo $transaction->date; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer class="text-center text-xs text-gray-500 mt-4">
        Projeto pessoal desenvolvido por
        <a href="https://github.com/deividsousan" class="text-indigo-600 hover:text-indigo-500 font-medium">
            @deividsousan
        </a>
    </footer>
</body>

</html>
