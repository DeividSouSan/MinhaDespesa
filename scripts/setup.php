<?php
// scripts/setup.php

// Garante que o script seja executado a partir da raiz do projeto para os caminhos funcionarem
require __DIR__ . '/../app/Infra/Database/database.php';

echo "🚀 Iniciando configuração do banco de dados...\n";

try {
    // Apenas obter a instância é suficiente para acionar a conexão
    // e a lógica de criação de tabelas dentro da classe Connection.
    query(
        "CREATE TABLE IF NOT EXISTS Transactions
        (
            TransactionId INT AUTO_INCREMENT PRIMARY KEY,
            Value DECIMAL(10, 2) NOT NULL,
            Category VARCHAR(255) NOT NULL,
            Date DATE NOT NULL,
            Description TEXT,
            Type ENUM('despesa', 'receita') NOT NULL
        );"
    );

    query(
        "CREATE TABLE IF NOT EXISTS Users
        (
            UserId INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255) NOT NULL UNIQUE,
            Email VARCHAR(255) NOT NULL UNIQUE,
            PasswordHash VARCHAR(255) NOT NULL,
            Token VARCHAR(255) NULL
        );"
    );

    query(
        "CREATE TABLE IF NOT EXISTS UserTransaction
        (
            UserTransactionId INT AUTO_INCREMENT PRIMARY KEY,
            IdUser INT NOT NULL,
            IdTransaction INT NOT NULL,
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
