<?php
class TransactionRepository
{
    public mysqli $database;

    function __construct()
    {
        $this->database = require '../app/Infra/Database/database.php';
    }

    function read()
    {
        $transactions = $this->database->query("SELECT * FROM Transaction ORDER BY date DESC;");
        if ($transactions->num_rows == 0) {
            return [];
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
