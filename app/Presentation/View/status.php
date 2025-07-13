<?php

require '../app/Infra/Database/database.php';

$result = query("show status where `variable_name` = 'Threads_connected'");
$open_connections = $result->fetch_all()[0][1];

$result = query("SHOW VARIABLES LIKE 'max_connections';");
$max_connections = $result->fetch_all()[0][1];

$result = query("SHOW VARIABLES LIKE 'version';");
$db_version = $result->fetch_all()[0][1];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
</head>
<body>
    <div>
        <p>Conexões abertas: <?php echo $open_connections ?></p>
        <p>Conexões máximas: <?php echo $max_connections ?></p>
        <p>Versão: <?php echo $db_version ?></p>
    </div>
</body>
</html>

