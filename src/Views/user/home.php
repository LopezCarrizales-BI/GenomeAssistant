<div class="home-content">

    <section class="search-section-card">
        <div class="search-header">
            <h2 class="search-title">Variant Search</h2>
            <p class="search-subtitle">Search by Variant ID, Position, or Gene</p>
        </div>

        <form id="search-form" class="main-search-form">
            <div class="search-bar-wrapper">
                <div class="input-container">
                    <?php echo Icon::get('search'); ?>
                    <input type="text" id="input" class="main-search-input"
                        placeholder="e.g. GRCh38 or 1:109274570 or rs7528419"
                        required
                        value="<?php echo htmlspecialchars($userInput['value'] ?? ''); ?>">
                </div>
                <button class="search-button-primary" type="submit">Search</button>
            </div>

            <div class="search-options-wrapper">
                <?php if (file_exists(ROOT_PATH . '/src/views/user/searchFields.php')) require_once ROOT_PATH . '/src/views/user/searchFields.php'; ?>
            </div>
        </form>
    </section>

    <div class="results-container">
        <div class="results-header">
            <h3 class="results-title">Results</h3>
            <div class="results-actions">
                <button class="action-button secondary" id="export-btn" type="button">
                    <div class="icon-box">
                        <?php echo Icon::get('csv'); ?>
                    </div>
                    <span>Export .csv</span>
                </button>

                <button class="action-button danger-ghost" id="clear-btn" type="button">
                    <div class="icon-box">
                        <?php echo Icon::get('delete'); ?>
                    </div>
                    <span>Clear search</span>
                </button>
            </div>
        </div>

        <section class="results-body" id="results-container">
            <div id="no-results-view" class="state-view">
                <div class="state-icon">
                    <?php echo Icon::get('database'); ?>
                </div>
                <p class="state-message">No results were found</p>
            </div>

            <div id="results-table-view" class="state-view" style="display: none;">
                <table class="generated-table">
                    <thead>
                        <tr>
                            <th>Variant ID</th>
                            <th>Chr:Pos (b38)</th>
                            <th>Gene</th>
                            <th>Effect Allele</th>
                            <th>Frequency (1kg)</th>
                        </tr>
                    </thead>
                    <tbody id="results-body">
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>