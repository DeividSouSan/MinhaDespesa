<?php
// só executa se o argumento --force for passado
if (!in_array('--force', $argv)) {
    echo "✋ AVISO: Este é um script destrutivo que irá apagar todas as tabelas.\n";
    echo "   Para confirmar, execute novamente com o argumento --force\n";
    echo "   Exemplo: php scripts/clean.php --force\n";
    exit(1);
}

require_once __DIR__ . '/../app/database.php';

echo "🔥 Iniciando limpeza do banco de dados...\n";

try {
    db_query('SET FOREIGN_KEY_CHECKS = 0;');

    db_query('DROP TABLE IF EXISTS UserTransaction;');
    echo "   - Tabela 'UserTransaction' removida.\n";

    db_query('DROP TABLE IF EXISTS Transactions;');
    echo "   - Tabela 'Transactions' removida.\n";

    db_query('DROP TABLE IF EXISTS Users;');
    echo "   - Tabela 'Users' removida.\n";

    db_query('SET FOREIGN_KEY_CHECKS = 1;');

    echo "✅ Banco de dados limpo com sucesso!\n";

} catch (Exception $e) {
    echo "❌ ERRO: Não foi possível limpar o banco de dados.\n";
    echo "   Mensagem: " . $e->getMessage() . "\n";
    exit(1);
}

exit(0);
