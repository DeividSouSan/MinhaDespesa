<?php
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
?>


<!DOCTYPE html>
<html>

<head>
    <title>MinhaDespesa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon"
        href="https://cdn.iconscout.com/icon/free/png-256/free-cash-icon-download-in-svg-png-gif-file-formats--money-currency-dollar-payment-bank-investing-and-finance-pack-business-icons-1746112.png"
        type="image/x-icon">
</head>

<body>
    <header>
        <div>
            <h1 class="app-logo">Minha🪙Despesa</h1>
            <img src="" alt="">
        </div>
    </header>

    <main>
        <!-- TELA FINANCAS   -->
        <section class="form-wrapper">
            <form action="/financas" method='GET'>
                <section class='field-wrapper'>
                    <label for="type">Tipo (📤/📥)</label>
                    <select name="type" id="type" onchange="this.form.submit()">
                        <option value=" despesa"
                            <?php echo !isset($_GET['type']) || $_GET['type'] == 'despesa' ? 'selected' : ''; ?>>
                            🔴Despesa</option>
                        <option value="receita"
                            <?php echo isset($_GET['type']) && $_GET['type'] == 'receita' ? 'selected' : ''; ?>>
                            🟢Receita</option>
                    </select>
                </section>
            </form>

            <form action="/financas" method='POST'>
                <input type="hidden" name="type" id='type'
                    value=<?php echo isset($_GET['type']) ? $_GET['type'] : 'despesa'; ?>>

                <section class='field-wrapper'>
                    <label for="value">💵 Valor (R$) </label>
                    <input type="number" name="value" id="value" placeholder="0,00" step="any">
                </section>

                <?php if (isset($_GET['type']) && $_GET['type'] == 'receita'): ?>
                    <section class='field-wrapper'>
                        <label for="category">🗃 Categoria</label>
                        <select name="category" id="category">
                            <option value="<?php echo CategoryIcon::Salario->value; ?>">💰 Salário</option>
                            <option value="<?php echo CategoryIcon::RendaExtra->value; ?>">🤑 Renda Extra</option>
                            <option value="<?php echo CategoryIcon::RendaPassiva->value; ?>">📈 Renda Passiva</option>
                        </select>
                    </section>
                <?php else: ?>
                    <section class='field-wrapper'>
                        <label for=" category">🗃 Categoria</label>
                        <select name="category" id="category">
                            <option value="<?php echo CategoryIcon::Moradia->value; ?>">🏠Moradia</option>
                            <option value="<?php echo CategoryIcon::Alimentacao->value; ?>">🥪Alimentação</option>
                            <option value="<?php echo CategoryIcon::Transporte->value; ?>">🚌Transporte</option>
                            <option value="<?php echo CategoryIcon::Viagens->value; ?>">✈Viagens</option>
                            <option value="<?php echo CategoryIcon::Saude->value; ?>">🏥Saúde</option>
                            <option value="<?php echo CategoryIcon::Educacao->value; ?>">🎓Educação</option>
                            <option value="<?php echo CategoryIcon::Compras->value; ?>">🛍Compras</option>
                            <option value="<?php echo CategoryIcon::Vestuario->value; ?>">👕Vestuário</option>
                            <option value="<?php echo CategoryIcon::Lazer->value; ?>">🧘‍♂️Lazer</option>
                        </select>
                    </section>
                <?php endif ?>

                <section class='field-wrapper'>
                    <label for="date">🗓 Data</label>
                    <input type="date" name="date" id="date" placeholder="DD/MM/YYYY">
                </section>

                <section class='field-wrapper'>
                    <label for="description">🗒 Descrição</label>
                    <input type="text" name="description" id="description">
                </section>

                <section class="field-wrapper">
                    <input type="submit" value="Adicionar ➕">
                </section>
            </form>
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

        <?php if (isset($_SESSION['missing-value']) && $_SESSION['missing-value']): ?>
            <section>
                faltando valores!!!
            </section>
        <?php endif ?>

        <section class="transactions-wrapper">
            <?php if ($transactionRepository->read()): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Cat</th>
                            <th>Valor</th>
                            <th>Descrição</th>
                            <th>Data</th>
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
                            ?>
                            <tr class='<?php echo $transaction->type; ?>'>
                                <td class='category-icon'><?php echo $transaction->category; ?> </td>
                                <td><?php echo "R$ {$transaction->value}"; ?> </td>
                                <td><?php echo $transaction->description; ?> </td>
                                <td class='transaction-date'><?php echo $transaction->date; ?> </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php else: ?>
                Sem transações realizadas;
            <?php endif ?>
        </section>
    </main>

    <footer>
        Projeto Pessoal desenvolvido por <a href="https://github.com/deividsousan">@deividsousan</a>
    </footer>
</body>

</html>