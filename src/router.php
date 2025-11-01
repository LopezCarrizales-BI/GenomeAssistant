<?php

function cleanPath($request_uri, $base_dir)
{
    $request_path = parse_url($request_uri, PHP_URL_PATH);

    if (strpos($request_path, $base_dir) === 0) {
        $request_path = substr($request_path, strlen($base_dir));
    }

    if (strpos($request_path, '/index.php') === 0) {
        $request_path = substr($request_path, strlen('/index.php'));
    }

    $request_path = rtrim($request_path, '/');
    if ($request_path === '') {
        $request_path = '/';
    }

    return $request_path;
}


function handleRoute($request_path, $base_dir)
{
    $data = [
        'resultados' => null,
        'error' => null,
        'userInput' => [],
        'view' => 'home.php'
    ];

    switch ($request_path) {

        case '/':
            break;

        case '/login':
            $data['view'] = 'login.php';
            break;

        case '/files':
            $data['view'] = 'files.php';
            break;

        case '/landing':
            $data['view'] = 'landing.php';
            break;

        case 'src/routes/apiRoutes.js':
            break;

        default:
            http_response_code(404);
            exit();
    }

    return $data;
}
