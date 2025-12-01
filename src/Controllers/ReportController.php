<?php

require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/src/Models/Report.php';

function saveReport()
{
    header('Content-Type: application/json');

    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $nombre = $input['nombre'] ?? 'Reporte sin título';
    $datos = $input['data'] ?? [];

    if (empty($datos)) {
        echo json_encode(['success' => false, 'error' => 'No hay datos']);
        exit;
    }

    try {
        $db = (new Database())->getConnection();
        $report = new Report($db);

        if ($report->save($_SESSION['user_id'], $nombre, json_encode($datos))) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Error al guardar en BD");
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

function deleteReport()
{
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id'])) {
        $db = (new Database())->getConnection();
        $report = new Report($db);

        if ($report->delete($input['id'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID faltante']);
    }
    exit;
}

function renameReport()
{
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id']) && isset($input['newName'])) {
        $db = (new Database())->getConnection();
        $report = new Report($db);

        if ($report->rename($input['id'], $input['newName'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo renombrar']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Datos faltantes']);
    }
    exit;
}

function getReportData()
{
    header('Content-Type: application/json');

    if (isset($_GET['id'])) {
        $db = (new Database())->getConnection();
        $reportModel = new Report($db);
        $report = $reportModel->getById($_GET['id']);

        if ($report) {
            echo json_encode([
                'success' => true,
                'data' => json_decode($report['datos_json']),
                'name' => $report['nombre_reporte']
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Reporte no encontrado']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID faltante']);
    }
    exit;
}
