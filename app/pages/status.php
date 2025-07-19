<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
</head>
<body>
    <h1>Status</h1>
    <p>Número de Conexões Ativas: <strong><?php echo $active_connections ?? "Houve um problema ao conseguir os dados."?></strong></p>
    <p>Número de Conexões Máximas: <strong><?php echo $max_connections ?? "Houve um problema ao conseguir os dados." ?></strong></p>
    <p>Versão do Banco de Dados: <strong><?php echo $database_version ?? "Houve um problema ao conseguir os dados." ?></strong></p>
</body>
</html>
