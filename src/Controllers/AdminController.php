<?php

require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/src/Models/User.php';

function getDashboardStats()
{
    $database = new Database();
    $db = $database->getConnection();

    $count = function ($table) use ($db) {
        $stmt = $db->query("SELECT COUNT(*) FROM $table");
        return $stmt->fetchColumn();
    };

    $stmtToday = $db->query("SELECT COUNT(*) FROM usuarios WHERE DATE(fecha_registro) = CURDATE()");
    $newUsers = $stmtToday->fetchColumn();

    $stmtRecent = $db->query("
        SELECT u.nombre_completo, u.email, u.activo, r.nombre as rol 
        FROM usuarios u 
        JOIN roles r ON u.rol_id = r.id 
        ORDER BY u.fecha_registro DESC 
        LIMIT 5
    ");
    $recentUsers = $stmtRecent->fetchAll(PDO::FETCH_ASSOC);

    return [
        'total_users' => $count('usuarios'),
        'total_searches' => $count('historial_busquedas'),
        'new_users_today' => $newUsers,
        'recent_users' => $recentUsers,
        'server_status' => 'Online'
    ];
}

function getAllUsers()
{
    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);

    $usersData = $userModel->getAll();

    $users = array_map(function ($u) {
        return [
            'id' => $u['id'],
            'name' => $u['nombre_completo'],
            'email' => $u['email'],
            'role' => ($u['rol_id'] == 1) ? 'admin' : 'user',
            'status' => ($u['activo'] == 1) ? 'active' : 'inactive',
            'created_at' => $u['fecha_registro'],
            'institution' => $u['institucion'] ?? 'N/A'
        ];
    }, $usersData);

    return ['users' => $users];
}

function createUser()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);

    $userModel->nombre_completo = $_POST['name'];
    $userModel->email = $_POST['email'];
    $userModel->password = $_POST['password'];
    $userModel->institucion = $_POST['institution'] ?? '';
    $userModel->rol_id = ($_POST['role'] == 'admin') ? 1 : 2;
    $userModel->activo = ($_POST['status'] == 'active') ? 1 : 0;

    if ($userModel->create()) {
        header('Location: ' . asset('/admin/users?success=created'));
    } else {
        header('Location: ' . asset('/admin/users?error=failed'));
    }
    exit;
}

function updateUser()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);

    $id = $_POST['user_id'];
    $data = [
        'nombre' => $_POST['name'],
        'email' => $_POST['email'],
        'institucion' => $_POST['institution'] ?? '', 
        'rol' => ($_POST['role'] == 'admin') ? 1 : 2,
        'activo' => ($_POST['status'] == 'active') ? 1 : 0,
        'password' => $_POST['password']
    ];

    if ($userModel->update($id, $data)) {
        header('Location: ' . asset('/admin/users?success=updated'));
    } else {
        header('Location: ' . asset('/admin/users?error=failed'));
    }
    exit;
}

function deleteUser()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);

    if ($userModel->delete($_POST['user_id'])) {
        header('Location: ' . asset('/admin/users?success=deleted'));
    } else {
        header('Location: ' . asset('/admin/users?error=failed'));
    }
    exit;
}
