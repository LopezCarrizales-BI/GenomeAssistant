<?php

define('ROOT_PATH', dirname(__DIR__));

define('BASE_URL', 'http://localhost:3000/');

define('BASE_DIR', '/public');

/**
 * Función que construye una URL web válida para recursos estáticos.
 * @param string $path La ruta relativa al recurso (ej: 'assets/css/style.css').
 * @return void Imprime la URL completa.
 */
function asset($path)
{
    echo BASE_URL . ltrim($path, '/');
}

require ROOT_PATH . '/vendor/autoload.php';

require_once ROOT_PATH . '/src/router.php';
require_once ROOT_PATH . '/src/Controllers/EnsemblController.php';

$request_uri = $_SERVER['REQUEST_URI'];
$request_path = cleanPath($request_uri, BASE_DIR);


$response_data = handleRoute($request_path, BASE_DIR);

$resultados = $response_data['resultados'] ?? null;
$error = $response_data['error'] ?? null;
$userInput = $response_data['userInput'] ?? [];
$viewFile = $response_data['view'] ?? 'home.php';


$view_path = ROOT_PATH . '/src/Views/' . $viewFile;
$layout_path = ROOT_PATH . '/src/Views/layout.php';

if ($viewFile === 'login.php') {
    if (file_exists($view_path)) {
        require_once $view_path;
        exit();
    } else {
        http_response_code(500);
        echo "Error interno: La vista de login no se encontró.";
        exit();
    }
}

if (file_exists($layout_path)) {
    require_once $layout_path;
} else {
    http_response_code(500);
}
