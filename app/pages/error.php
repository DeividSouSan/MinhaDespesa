<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>
</head>

<body>
    <h1><?php echo $error->getName(); ?></h1>
    <p><?php echo $error->getMessage(); ?></p>
    <p><?php echo $error->getAction(); ?></p>
    <p><strong><?php echo $error->getCode(); ?></strong></p>
</body>

</html>
