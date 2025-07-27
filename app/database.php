<?php
require_once '../app/errors.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function db_query(string $query, ?array $params = [], ?string $types = ''): mysqli_result|bool
{
    try {
        $db = new mysqli(
            'mysql-database',
            'local_user',
            'local_password',
            'local_db',
            3306
        );

        if ($params !== null && $params !== []) {
            $stmt = $db->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();

            return true;
        }

        $result = $db->query($query);

        if ($result === false) {
            echo "Houve um problema na consulta.";
        }

        return $result;
    } catch (mysqli_sql_exception $error) { // qualquer exceção lançado pelo mysqli será desse exato tipo
        error_log("Erro de Banco de Dados: " . $error->getMessage()); // mensagem para o desenvolvedor
        throw new DatabaseError(); // encerra o script, mas poderia ser outra exceção
    } finally {
        if (isset($db)) {
            $db->close();
        }
    }
}
