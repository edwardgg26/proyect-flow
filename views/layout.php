<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProyectFlow
        <?php echo " | " . $titulo ?? "" ?>
    </title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>

    <?php echo $contenido; ?>
    <?php echo $script ?? ''; ?>
    <script src="/build/js/app.js"></script>
    <script src="/build/js/bootstrap.bundle.min.js"></script>
</body>
</html>