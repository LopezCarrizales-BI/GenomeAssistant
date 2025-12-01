<?php

require_once ROOT_PATH . '/config/database.php';

function login()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . asset('/login'));
        exit();
    }

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['error'] = "Error de conexión a la base de datos.";
        header('Location: ' . asset('/login'));
        exit();
    }

    $query = "SELECT id, nombre_completo, password, rol_id, activo FROM usuarios WHERE email = :email LIMIT 1";

    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                if (!$row['activo']) {
                    if (session_status() === PHP_SESSION_NONE) session_start();
                    $_SESSION['error'] = 'Tu cuenta está desactivada.';
                    header('Location: ' . asset('/login'));
                    exit();
                }
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['nombre_completo'];
                $_SESSION['role'] = ($row['rol_id'] == 1) ? 'admin' : 'user';

                if ($_SESSION['role'] === 'admin') {
                    header('Location: ' . asset('/dashboard'));
                } else {
                    header('Location: ' . asset('/home'));
                }
                exit();
            }
        }
    } catch (PDOException $e) {
        error_log("Error en login: " . $e->getMessage());
    }

    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['error'] = 'Correo o contraseña incorrectos.';
    header('Location: ' . asset('/login'));
    exit();
}

function logout()
{
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION = [];
    session_destroy();
    header('Location: ' . asset('/login'));
    exit();
}

function register()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . asset('/create-account'));
        exit();
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $institution = trim($_POST['institution'] ?? ''); 

    $database = new Database();
    $db = $database->getConnection();

    $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);

    if ($stmt->rowCount() > 0) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['error'] = "El correo ya está registrado.";
        header('Location: ' . asset('/create-account'));
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $rol_id = 2;
    $activo = 1;

    $sql = "INSERT INTO usuarios (nombre_completo, email, password, rol_id, activo, institucion, fecha_registro) 
            VALUES (:name, :email, :password, :rol, :activo, :inst, NOW())";

    try {
        $insertStmt = $db->prepare($sql);
        $insertStmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hashed_password,
            ':rol' => $rol_id,
            ':activo' => $activo,
            ':inst' => $institution
        ]);

        $newUserId = $db->lastInsertId();
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['user_id'] = $newUserId;
        $_SESSION['user_name'] = $name;
        $_SESSION['role'] = 'user';

        header('Location: ' . asset('/home'));
        exit();
    } catch (PDOException $e) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['error'] = "Error al registrar: " . $e->getMessage();
        header('Location: ' . asset('/create-account'));
        exit();
    }
}
