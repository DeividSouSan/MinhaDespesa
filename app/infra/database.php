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
