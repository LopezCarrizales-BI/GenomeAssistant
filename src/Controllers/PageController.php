<?php

require_once ROOT_PATH . '/config/database.php';

function getFilesData()
{
    return ['documents' => []];
}

function getUserProfile()
{
    if (!isset($_SESSION['user_id'])) {
        return ['user_data' => []];
    }

    $userId = $_SESSION['user_id'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT u.nombre_completo, u.email, u.institucion, u.fecha_registro, r.nombre as nombre_rol 
              FROM usuarios u 
              LEFT JOIN roles r ON u.rol_id = r.id 
              WHERE u.id = :id 
              LIMIT 1";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_data = [
            'name' => $user['nombre_completo'],
            'email' => $user['email'],
            'institution' => $user['institucion'] ?? 'Not specified',
            'role' => $user['nombre_rol'] ?? 'User',
            'joined_at' => $user['fecha_registro'],

            'country' => 'Global',
            'linkedin' => ''
        ];
    } else {
        $user_data = [
            'name' => 'Unknown User',
            'role' => 'Guest',
            'institution' => 'N/A',
            'country' => 'N/A',
            'joined_at' => date('Y-m-d'),
            'email' => ''
        ];
    }

    return ['user_data' => $user_data];
}
