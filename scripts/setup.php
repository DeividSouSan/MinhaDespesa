<?php
// scripts/setup.php

// Garante que o script seja executado a partir da raiz do projeto para os caminhos funcionarem
require __DIR__ . '/../app/database.php';

echo "🚀 Iniciando configuração do banco de dados...\n";

try {
    // Apenas obter a instância é suficiente para acionar a conexão
    // e a lógica de criação de tabelas dentro da classe Connection.
    db_query(
        "CREATE TABLE IF NOT EXISTS Transactions
        (
            transactionId INT AUTO_INCREMENT PRIMARY KEY,
            value DECIMAL(10, 2) NOT NULL,
            category VARCHAR(255) NOT NULL,
            date DATE NOT NULL,
            description TEXT,
            type ENUM('despesa', 'receita') NOT NULL
        );"
    );

    db_query(
        "CREATE TABLE IF NOT EXISTS Users
        (
            userId INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );"
    );

    db_query(
        "CREATE TABLE IF NOT EXISTS UserTransaction
        (
            userTransactionId INT AUTO_INCREMENT PRIMARY KEY,
            idUser INT NOT NULL,
            idTransaction INT NOT NULL,
            FOREIGN KEY (IdUser) REFERENCES Users(UserId),
            FOREIGN KEY (IdTransaction) REFERENCES Transactions(TransactionId)
        );"
    );

    echo "✅ Tabelas 'User' e 'Transaction' verificadas/criadas com sucesso!\n";
    echo "✨ Configuração concluída.\n";

} catch (Exception $e) {
    echo "❌ ERRO: Não foi possível completar a configuração.\n";
    echo "   Mensagem: " . $e->getMessage() . "\n";
    exit(1); // Sai com um código de erro
}

exit(0); // Sucesso
