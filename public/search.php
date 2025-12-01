<?php

if (ob_get_length()) ob_clean();
ob_start();

ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

try {
    if (file_exists(ROOT_PATH . '/src/controllers/EnsemblController.php')) {
        require_once ROOT_PATH . '/src/controllers/EnsemblController.php';
    } else {
        throw new Exception("No se encuentra EnsemblController.");
    }

    if (file_exists(ROOT_PATH . '/src/models/SearchHistory.php')) {
        require_once ROOT_PATH . '/src/models/SearchHistory.php';
    } else {
        throw new Exception("No se encuentra SearchHistory.");
    }

    require_once ROOT_PATH . '/config/database.php';

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    $database = $input['database'] ?? $_REQUEST['database'] ?? 'snp';
    $term     = $input['term']     ?? $_REQUEST['term']     ?? null;
    $type     = $input['type']     ?? $_REQUEST['type']     ?? 'snp';

    if (empty($term)) {
        throw new Exception("El término de búsqueda está vacío.");
    }

    $databaseConn = new Database();
    $db = $databaseConn->getConnection();

    $controller = new EnsemblController($db);
    $results = $controller->search($database, $term);

    if ($db && class_exists('SearchHistory')) {
        try {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $userId = $_SESSION['user_id'] ?? 1;

            $history = new SearchHistory($db);
            $encontrado = (count($results) > 0) ? 1 : 0;
            $history->log($userId, $term, $type, $encontrado);
        } catch (Exception $eHistory) {
            error_log("Error historial: " . $eHistory->getMessage());
        }
    }

    ob_clean();
    echo json_encode([
        'success' => true,
        'data' => $results
    ]);
} catch (Exception $e) {
    ob_clean();
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

exit;
