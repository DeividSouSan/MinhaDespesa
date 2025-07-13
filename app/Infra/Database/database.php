<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function query(string $query): mysqli_result
{
    try {
        $db = new mysqli(
            'mysql-database',
            'local_user',
            'local_password',
            'local_db',
            3306
        );

        $result = $db->query($query);
        return $result;
    } catch (mysqli_sql_exception $error) { // qualquer exceção lançado pelo mysqli será desse exato tipo
        error_log("Erro de Banco de Dados: " . $error->getMessage()); // mensagem para o desenvolvedor
        die('Erro: Não foi possível inicializar o banco de dados. Tente novamente mais tarde.'); // encerra o script, mas poderia ser outra exceção
    } finally {
        $db->close();
    }
}
