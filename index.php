<?php
define('DATABASE_HOST', 'mysql-database');
define('DATABASE_PORT', 3306);
define('DATABASE_NAME', 'local_db');
define('DATABASE_USER', 'local_user');
define('DATABASE_PASSWORD', 'local_password');

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $db = mysqli_connect(
        DATABASE_HOST,
        DATABASE_USER,
        DATABASE_PASSWORD,
        DATABASE_NAME,
        DATABASE_PORT
    );

    $create_transactions_table_query = $db->prepare("
    CREATE TABLE IF NOT EXISTS Transaction 
    (
        id INT AUTO_INCREMENT PRIMARY KEY,
        value DECIMAL(10, 2) NOT NULL,
        category VARCHAR(255) NOT NULL,
        date DATE NOT NULL,
        description TEXT,
        type ENUM('despesa', 'receita') NOT NULL
    );");

    $create_transactions_table_query->execute();
} catch (mysqli_sql_exception) {
    echo 'Não foi possível conectar ao banco de dados.';
}

// Entities
class TransactionDTO
{
    public $value;
    public $category;
    public $date;
    public $description;
    public $type;

    function __construct(string $value, string $category, string $date, string $description, string $type)
    {
        $this->value = (float) $value;
        $this->category = $category;
        $this->date = new DateTime($date);
        $this->description = $description;
        $this->type = $type;
    }
}

// Repositories
class TransactionRepository
{
    public mysqli $database;

    function __construct(mysqli $db)
    {
        $this->database = $db;
    }

    function read()
    {
        $transactions = $this->database->query("SELECT * FROM Transaction;");
        return $transactions;
    }

    function add(TransactionDTO $transaction)
    {
        $value = $transaction->value;
        $category = $transaction->category;
        $date = $transaction->date->format('Y/m/d');
        $description = $transaction->description;
        $type = $transaction->type;

        try {
            $stmt = $this->database->prepare("
            INSERT INTO Transaction (value, category, date, description, type)
            VALUES (?,?,?,?,?);
            ");

            $stmt->bind_param("dssss", $value, $category, $date, $description, $type);

            $result = $stmt->execute();

            /*
            if ($result == true) {
                echo "hey";
            } else {
                echo "aff";
            }*/
        } catch (Exception $err) {
            echo $err;
        }
    }

    function remove() {}
}


function set_transaction_type(TransactionDTO $transaction): string
{
    if ($transaction->type == "despesa") {
        $transaction_date = $transaction->date;
        $current_date = new DateTime(date('Y-m-d', time()));

        return ($transaction_date > $current_date) ? "despesa-futura" : "despesa";
    }
    return "receita";
};

$transactionRepository = new TransactionRepository($db);

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

                $transaction = new TransactionDTO($value, $category, $date, $description, $type);
                $transactionRepository->add($transaction);
            }
        }
        ?>

        <section class="transactions-wrapper">
            <?php if ($transactionRepository->read()): ?>
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
                        <?php foreach ($transactionRepository->read() as $transaction): ?>
                            <?php
                            $transaction = new TransactionDTO($transaction['value'], $transaction['category'], $transaction['date'], $transaction['description'], $transaction['type']);
                            $classe = set_transaction_type($transaction);
                            $formated_value = number_format($transaction->value, 2, ',', '.');
                            $formated_transaction_date = ($transaction->date)->format('d/m/Y');

                            ?>
                            <tr class='<?php echo $classe ?>'>
                                <td><?php echo $transaction->type; ?></td>
                                <td><?php echo "R$ {$formated_value}"; ?> </td>
                                <td><?php echo $transaction->category; ?> </td>
                                <td><?php echo $transaction->description; ?> </td>
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