<?php

require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/src/models/Report.php';


try {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . asset('/login'));
        exit;
    }

    $userId = $_SESSION['user_id'];

    $database = new Database();
    $db = $database->getConnection();

    $reportModel = new Report($db);

    $documents = $reportModel->getByUser($userId);
} catch (Exception $e) {
    $documents = [];
    error_log("Error cargando archivos: " . $e->getMessage());
}
?>

<div class="files-container">

    <div class="navbar-search">
        <div class="search-bar">
            <img class="search-icon" alt="Search" src="<?php echo asset('/assets/img/searchIcon.svg') ?>">
            <form class="search-form">
                <input class="search-input" type="text" placeholder="Search file...">
            </form>
        </div>

        <div class="search-filters">
            <label for="filters" class="filter-label">Sort by:</label>
            <select class="filter-select" name="filters" id="filters">
                <option value="a-z">Name (A-Z)</option>
                <option value="z-a">Name (Z-A)</option>
                <option value="newToOld">Newest</option>
                <option value="OldToNew">Oldest</option>
            </select>
        </div>
    </div>

    <div class="files">
        <?php
        if (isset($documents) && is_array($documents) && count($documents) > 0) {
            foreach ($documents as $document) {
                include ROOT_PATH . '/src/views/user/document.php';
            }
        } else {
            echo '<div style="padding: 20px; text-align: center; color: #666;">No saved files yet.</div>';
        }
        ?>
    </div>
</div>

<script src="<?php echo asset('/assets/js/files.js') ?>"></script>