<div class="home-content">
    <section class="search-section">
        <form id="search-form" class="search-form">
            <?php require_once ROOT_PATH . '\src\Views\searchFields.php' ?>

            <div class="search">
                <fieldset class="search-bar">
                    <legend>Search:</legend>
                    <input type="text" id="input" placeholder="e.g. GRCh38 or 1:109274570 or rs7528419" required value="<?php echo htmlspecialchars($userInput['value'] ?? ''); ?>">
                </fieldset>

                <button class="search-button" type="submit">Search</button>
            </div>
        </form>
    </section>

    <div class="results-container">
        <div class="results-header">
            <h3 class="results-title">Resultados</h3>
            <div class="results-buttons">
                <a class="results-button">
                    <div class="csv-icon">
                        <?php
                        $svgPath = ROOT_PATH . '/public/assets/img/csv.svg';
                        if (file_exists($svgPath)) {
                            echo file_get_contents($svgPath);
                        } else {
                            echo '';
                        }
                        ?>
                    </div>
                    <p>Export .csv</p>
                </a>
                <a class="results-button">
                    <div class="trash-icon">
                        <?php
                        $svgPath = ROOT_PATH . '/public/assets/img/trash.svg';
                        if (file_exists($svgPath)) {
                            echo file_get_contents($svgPath);
                        } else {
                            echo '';
                        }
                        ?>
                    </div>
                    <p>Clear search</p>
                </a>
            </div>
        </div>
        <section class="results" id="results-container">
            <div id="results-pre">
                <div class="database-icon">
                    <?php
                    $svgPath = ROOT_PATH . '/public/assets/img/database.svg';
                    if (file_exists($svgPath)) {
                        echo file_get_contents($svgPath);
                    } else {
                        echo '';
                    }
                    ?>
                </div>
                <p class="results-message">No results were found</p>

            </div>
        </section>
    </div>
</div>