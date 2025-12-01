<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>GenomeAssistant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Benjamín Iván López Carrizales">
    <meta name="description" content="A web application for automatic search and analysis of SNPs (Single Nucleotide Polymorphisms) to support genomic research.">

    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'normalize.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'tokens.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'header.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'layout.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset(CSS_PATH . 'footer.css'); ?>">

    <?php
    foreach ($view_stylesheets as $css_file) {
        echo '<link rel="stylesheet" href="' . asset(CSS_PATH . $css_file) . '">';
    }
    ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <?php require_once ROOT_PATH . VIEWS_PATH . 'header.php'; ?>

    <main>
        <?php require_once $view_path; ?>
    </main>

    <?php require_once ROOT_PATH . VIEWS_PATH . 'footer.php'; ?>

    <script>
        const BASE_URL = "<?php echo rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); ?>";
        const API_BASE_URL = "<?php echo asset('/'); ?>";
    </script>

    <script src="<?php echo asset('/assets/js/header.js'); ?>"></script>

    <script src="<?php echo asset('/assets/js/main.js'); ?>" type="module"></script>

    <?php if (isset($view_scripts)): ?>
        <?php foreach ($view_scripts as $script): ?>
            <script src="<?php echo asset('/assets/js/' . $script); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>