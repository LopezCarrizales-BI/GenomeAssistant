<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>GenomeAsistant | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Benjamín Iván López Carrizales">
    <meta name="description" content="Página para iniciar sesión en GenomeAsistant">
    <link rel="stylesheet" href="<?php asset('assets/css/normalize.css'); ?>">
    <link rel="stylesheet" href="<?php asset('assets/css/header.css'); ?>">
    <link rel="stylesheet" href="<?php asset('assets/css/home.css'); ?>">
    <link rel="stylesheet" href="<?php asset('assets/css/footer.css'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>

    <?php require_once '../src/Views/header.php' ?>

    <main>
        <section class="search-section">
            <form action="<?php echo BASE_URL; ?>ensembl/buscar" method="POST">
                <fieldset>
                    <legend>Search by data type:</legend>
                    <label><input type="radio" name="data-type" value="snp" <?php echo ($userInput['data-type'] ?? '') === 'snp' ? 'checked' : ''; ?> required> SNP</label>
                    <label><input type="radio" name="data-type" value="name" <?php echo ($userInput['data-type'] ?? '') === 'name' ? 'checked' : ''; ?> required> Name</label>
                    <label><input type="radio" name="data-type" value="genomic-coordinates" <?php echo ($userInput['data-type'] ?? '') === 'genomic-coordinates' ? 'checked' : ''; ?> required> Genomic Coordinates</label>
                </fieldset>

                <fieldset>
                    <legend>Value:</legend>
                    <input type="text" name="value" placeholder="Enter value" required value="<?php echo htmlspecialchars($userInput['value'] ?? ''); ?>">
                </fieldset>

                <button type="submit">Search</button>
            </form>
        </section>

        <section class="results-section">
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <h3>Error</h3>
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($resultados)): ?>
                <div class="results-data">
                    <h3>Resultados de la Búsqueda</h3>
                    <pre><?php echo json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?></pre>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php require_once '../src/Views/footer.php' ?>

</body>

</html>