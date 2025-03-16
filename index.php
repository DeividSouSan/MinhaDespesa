<?php
session_start();

//session_unset();

define('DATABASE_HOST', 'mysql-database');
define('DATABASE_PORT', 3306);
define('DATABASE_NAME', 'local_db');
define('DATABASE_USER', 'local_user');
define('DATABASE_PASSWORD', 'local_password');

$db = mysqli_connect(
    DATABASE_HOST,
    DATABASE_USER,
    DATABASE_PASSWORD,
    DATABASE_NAME,
    DATABASE_PORT
);

if (mysqli_connect_errno()) {
    die("Connection Failed: " . mysqli_connect_errno());
}

class Transaction
{
    public $value;
    public $category;
    public $date;
    public $description;
    public $type;

    function __construct(string $value, string $category, string $date, string $description, string $type)
    {
        $this->value = $value;
        $this->category = $category;
        $this->date = $date;
        $this->description = $description;
        $this->type = $type;
    }
}

function set_transaction_type(Transaction $transaction): string
{
    if ($transaction->type == "despesa") {
        $transaction_date = new DateTime($transaction->date);
        $current_date = new DateTime(date('Y-m-d', time()));

        return ($transaction_date > $current_date) ? "despesa-futura" : "despesa";
    }
    return "receita";
};
?>

<!DOCTYPE html>
<html>

<head>
    <title>MinhaDespesa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="https://cdn.iconscout.com/icon/free/png-256/free-cash-icon-download-in-svg-png-gif-file-formats--money-currency-dollar-payment-bank-investing-and-finance-pack-business-icons-1746112.png" type="image/x-icon">
</head>

<body>
    <header>
        <div>
            <h1 class="app-logo">Minha🪙Despesa</h1>
            <img src="" alt="">
        </div>

        <section class="form-wrapper">
            <form action="index.php" method='GET'>
                <section class='field-wrapper'>
                    <label for="type">Tipo (📤/📥)</label>
                    <select name="type" id="type" onchange="this.form.submit()">
                        <option value=" despesa" <?php echo (!isset($_GET['type']) || $_GET['type'] == 'despesa') ? 'selected' : ''; ?>>🔴Despesa</option>
                        <option value="receita" <?php echo (isset($_GET['type']) && $_GET['type'] == 'receita') ? 'selected' : ''; ?>>🟢Receita</option>
                    </select>
                </section>
            </form>

            <form action="index.php" method='POST'>
                <input type="hidden" name="type" id='type' value=<?php echo (isset($_GET['type'])) ? $_GET['type'] : 'despesa'; ?>>

                <section class='field-wrapper'>
                    <label for="value">💵 Valor (R$) </label>
                    <input type="number" name="value" id="value" placeholder="0,00" step="any">
                </section>

                <?php if (isset($_GET['type']) && $_GET['type'] == 'receita'): ?>
                    <section class='field-wrapper'>
                        <label for=" category">🗃 Categoria</label>
                        <select name="category" id="category">
                            <option value="salario">💰 Salário</option>
                            <option value="renda-extra">🤑 Renda Extra</option>
                            <option value="renda-passiva">📈 Renda Passiva</option>
                        </select>
                    </section>
                <?php else: ?>
                    <section class='field-wrapper'>
                        <label for=" category">🗃 Categoria</label>
                        <select name="category" id="category">
                            <option value="moradia">🏠Moradia</option>
                            <option value="alimentacao">🥪Alimentação</option>
                            <option value="transporte">🚌Transporte</option>
                            <option value="viagens">✈Viagens</option>
                            <option value="saude">🏥Saúde</option>
                            <option value="educacao">🎓Educação</option>
                            <option value="compras">🛍Compras</option>
                            <option value="vestuario">👕Vestuário</option>
                            <option value="lazer">🧘‍♂️Lazer</option>
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
    </header>

    <main>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if (isset($_POST['value']) && isset($_POST['category']) && isset($_POST['date']) && isset($_POST['description'])) {
                $value = $_POST['value'];
                $category = $_POST['category'];
                $date = $_POST['date'];
                $description = $_POST['description'];
                $type = (isset($_POST['type']) ? $_POST['type'] : 'despesa');

                $transacao = new Transaction($value, $category, $date, $description, $type);

                if (isset($_SESSION['transacoes'])) {
                    $_SESSION['transacoes'][] = $transacao;
                } else {
                    $_SESSION['transacoes'] = [];
                    array_unshift($_SESSION['transacoes'], $transacao);
                }
            }
        }
        ?>

        <section class="transactions-wrapper">
            <?php if (isset($_SESSION["transacoes"])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['transacoes'] as $transacao): ?>
                            <?php
                            $classe = set_transaction_type($transacao);
                            $formated_value = number_format($transacao->value, 2, ',', '.');
                            $formated_transaction_date = (new DateTime($transacao->date))->format('d/m/Y');

                            ?>
                            <tr class='<?php echo $classe ?>'>
                                <td><?php echo $transacao->type; ?></td>
                                <td><?php echo "R$ {$formated_value}"; ?> </td>
                                <td><?php echo $transacao->category; ?> </td>
                                <td><?php echo $transacao->description; ?> </td>
                                <td><?php echo $formated_transaction_date; ?> </td>
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