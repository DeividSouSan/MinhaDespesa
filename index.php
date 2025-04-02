<?php
session_start();

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

// DTO
class TransactionDTO
{
    public $value;
    public $category;
    public $date;
    public $description;
    public $type;

    function __construct(array $array)
    {
        $this->value = $array['value'];
        $this->category = $array['category'];
        $this->date = new DateTime($array['date']);
        $this->description = $array['description'];
        $this->type = $array['type'];
    }
}

class TransactionPresenter
{
    public $value;
    public $category;
    public $date;
    public $description;
    public $type;

    function __construct(string $value, string $category, string $date, string $description, string $type)
    {
        $this->value = $this->format_value($value);
        $this->category = $category;
        $this->date = $this->format_date($date);
        $this->description = $description;
        $this->type = $this->format_type($type, $date);
    }

    public function format_value(string $value): string
    {
        $value = (float) $value;
        return number_format($value, 2, ',', '.');
    }

    public function format_type(string $type, string $date): string
    {
        if ($type == "despesa") {
            $transaction_date = new DateTime($date);
            $current_date = new DateTime(date('Y-m-d', time()));

            return ($transaction_date > $current_date) ? "despesa-futura" : "despesa";
        }
        return "receita";
    }

    public function format_date($date): string
    {
        $date = (new DateTime($date))->format('d/m/Y');

        $months = [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];

        $dateParts = explode('/', $date);
        $formattedDate = "{$dateParts[0]} de {$months[$dateParts[1]]} de {$dateParts[2]}";

        return $formattedDate;
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
        $transactions = $this->database->query("SELECT * FROM Transaction ORDER BY date DESC;");
        if ($transactions->num_rows == 0) {
            return null;
        };
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


    </header>

    <main>
        <section class="form-wrapper">
            <form action="index.php" method='GET'>
                <section class='field-wrapper'>
                    <label for="type">Tipo (📤/📥)</label>
                    <select name="type" id="type" onchange="this.form.submit()">
                        <option value=" despesa" <?php echo !isset($_GET['type']) || $_GET['type'] == 'despesa' ? 'selected' : ''; ?>>🔴Despesa</option>
                        <option value="receita" <?php echo isset($_GET['type']) && $_GET['type'] == 'receita' ? 'selected' : ''; ?>>🟢Receita</option>
                    </select>
                </section>
            </form>

            <form action="index.php" method='POST'>
                <input type="hidden" name="type" id='type' value=<?php echo isset($_GET['type']) ? $_GET['type'] : 'despesa'; ?>>

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