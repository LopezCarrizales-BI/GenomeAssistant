<?php

function cleanPath($request_uri, $base_dir)
{
    $request_path = parse_url($request_uri, PHP_URL_PATH);

    $request_path = urldecode($request_path);

    if ($base_dir !== '/' && stripos($request_path, $base_dir) === 0) {
        $request_path = substr($request_path, strlen($base_dir));
    }

    if (stripos($request_path, '/index.php') === 0) {
        $request_path = substr($request_path, strlen('/index.php'));
    }

    // $request_path = rtrim($request_path, '/');

    return $request_path;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

function handleRoute($request_path)
{
    $data = [
        'view' => 'home.php',
        'stylesheets' => [],
        'auth_required' => false,
        'role_required' => null,
        'controller_action' => null
    ];

    switch ($request_path) {
        case '/':
            $data['view'] = 'landing.php';
            $data['stylesheets'][] = 'landing.css';
            break;

        case '/login':
            $data['view'] = 'login.php';
            $data['stylesheets'][] = 'login.css';
            break;

        case '/home':
            $data['view'] = 'user/home.php';
            $data['stylesheets'][] = 'user/home.css';
            break;

        case '/files':
            $data['view'] = 'user/files.php';
            $data['stylesheets'] = ['user/files.css', 'user/document.css', 'user/document_menu.css'];
            $data['auth_required'] = true;
            $data['controller_action'] = 'getFilesData';
            break;

        case '/help':
            $data['view'] = 'user/help.php';
            $data['stylesheets'][] = 'user/help.css';
            $data['auth_required'] = true;
            break;

        case '/dashboard':
            $data['view'] = 'admin/dashboard.php';
            $data['stylesheets'][] = 'admin/dashboard.css';
            $data['auth_required'] = true;
            $data['role_required'] = 'admin';
            break;

        case '/users':
            $data['view'] = 'admin/users.php';
            $data['stylesheets'][] = 'admin/users.css';
            $data['auth_required'] = true;
            $data['role_required'] = 'admin';
            $data['controller_action'] = 'getAllUsers';
            break;

        case '/profile':
            $data['view'] = 'user/profile.php';
            $data['stylesheets'][] = 'profile.css';
            $data['auth_required'] = true;
            $data['controller_action'] = 'getUserProfile';
            break;

        case '/logout':
            $data['controller_action'] = 'logout';
            break;

        case '/admin/users/create':
            $data['controller_action'] = 'createUser';
            break;

        case '/admin/users/update':
            $data['controller_action'] = 'updateUser';
            break;

        case '/admin/users/delete':
            $data['controller_action'] = 'deleteUser';
            break;

        case '/create-account':
            $data['view'] = 'create_account.php';
            $data['stylesheets'][] = 'login.css';
            break;

        case '/auth/register':
            $data['controller_action'] = 'register';
            $data['auth_required'] = false;
            break;

        case '/password':
            $data['view'] = 'password.php';
            $data['stylesheets'][] = 'login.css';
            break;

        case '/auth/login':
            $data['controller_action'] = 'login';
            $data['auth_required'] = false;
            break;

        case '/api/search':
            $data['view'] = null;
            $apiPath = ROOT_PATH . '/public/search.php';

            if (file_exists($apiPath)) {
                require_once $apiPath;
            } else {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['error' => 'Archivo de búsqueda no encontrado en: ' . $apiPath]);
            }
            exit();
            break;

        case '/api/report/save':
            require_once ROOT_PATH . '/src/controllers/ReportController.php';
            $data['controller_action'] = 'saveReport';
            break;

        case '/api/report/rename':
            $data['view'] = null;
            require_once ROOT_PATH . '/src/controllers/ReportController.php';
            $data['controller_action'] = 'renameReport';
            break;

        case '/api/report/get':
            $data['view'] = null;
            require_once ROOT_PATH . '/src/controllers/ReportController.php';
            $data['controller_action'] = 'getReportData';
            break;

        case '/api/report/delete':
            $data['view'] = null;
            require_once ROOT_PATH . '/src/controllers/ReportController.php';
            $data['controller_action'] = 'deleteReport';
            break;

        default:
            $data['view'] = '404.php';
            $data['stylesheets'][] = '404.css';
            break;
    }

    return $data;
}
