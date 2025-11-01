<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>GenomeAssistant | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Benjamín Iván López Carrizales">
    <meta name="description" content="Página de la aplicación GenomeAsistant">

    <link rel="stylesheet" href="<?php asset('/assets/css/normalize.css'); ?>">
    <link rel="stylesheet" href="<?php asset('/assets/css/header.css'); ?>">
    <link rel="stylesheet" href="<?php asset('/assets/css/layout.css'); ?>">
    <link rel="stylesheet" href="<?php asset('/assets/css/home.css'); ?>">
    <link rel="stylesheet" href="<?php asset('/assets/css/searchFields.css'); ?>">
    <link rel="stylesheet" href="<?php asset('/assets/css/footer.css'); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <?php require_once ROOT_PATH . '/src/Views/header.php'; ?>

    <main>
        <?php
        if (isset($view_path) && file_exists($view_path)) {
            require_once $view_path;
        } else {
            echo "<h1>Contenido de vista no disponible.</h1>";
        }
        ?>
    </main>

    <?php require_once ROOT_PATH . '/src/Views/footer.php'; ?>

    <script src="<?php asset('/assets/js/main.js'); ?>" type="module"></script>
</body>

</html>