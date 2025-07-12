<?php
// Define as credenciais do banco de dados
if (!defined('DATABASE_HOST')) define('DATABASE_HOST', 'mysql-database');
if (!defined('DATABASE_PORT')) define('DATABASE_PORT', 3306);
if (!defined('DATABASE_NAME')) define('DATABASE_NAME', 'local_db');
if (!defined('DATABASE_USER')) define('DATABASE_USER', 'local_user');
if (!defined('DATABASE_PASSWORD')) define('DATABASE_PASSWORD', 'local_password');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// esse código será importado apenas uma vez

try {
    $db = mysqli_connect(
        DATABASE_HOST,
        DATABASE_USER,
        DATABASE_PASSWORD,
        DATABASE_NAME,
        DATABASE_PORT
    );

    $db->query(
        "
            CREATE TABLE IF NOT EXISTS Transactions
            (
            TransactionId INT AUTO_INCREMENT PRIMARY KEY,
            Value DECIMAL(10, 2) NOT NULL,
            Category VARCHAR(255) NOT NULL,
            Date DATE NOT NULL,
            Description TEXT,
            Type ENUM('despesa', 'receita') NOT NULL
            );"
    );

    $db->query(
        "
            CREATE TABLE IF NOT EXISTS Users
            (
            UserId INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL UNIQUE,
            Email VARCHAR(255) NOT NULL UNIQUE,
            PasswordHash VARCHAR(255) NOT NULL,
            Token VARCHAR(255) NULL
            );"
    );

    $db->query(
        "
            CREATE TABLE IF NOT EXISTS UserTransaction
            (
            UserTransactionId INT AUTO_INCREMENT PRIMARY KEY,
            IdUser INT NOT NULL,
            IdTransaction INT NOT NULL,
            FOREIGN KEY (IdUser) REFERENCES Users(UserId),
            FOREIGN KEY (IdTransaction) REFERENCES Transactions(TransactionId)
            );"
    );
} catch (mysqli_sql_exception $error) { // qualquer exceção lançado pelo mysqli será desse exato tipo
    error_log("Erro de Banco de Dados: " . $error->getMessage()); // mensagem para o desenvolvedor
    die('Erro: Não foi possível inicializar o banco de dados. Tente novamente mais tarde.'); // encerra o script, mas poderia ser outra exceção
}

return $db;
