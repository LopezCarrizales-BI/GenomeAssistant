<?php

define('BASE_URL', 'http://localhost/GenomeAsistant/public/');

function asset($path)
{
    echo BASE_URL . $path;
}

require_once '../src/Controllers/EnsemblController.php';
require '../vendor/autoload.php';

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_path = str_replace('/GenomeAsistant/public', '', $request_uri);

if ($request_path === '') {
    $request_path = '/';
}

// Inicializamos las variables que la vista podría necesitar
$resultados = null;
$error = null;
$userInput = [];

switch ($request_path) {

    case '/':
        // Simplemente muestra la página home vacía
        break;

    case '/ensembl/buscar':
        // Si la ruta es la de búsqueda, procesamos los datos
        $controller = new EnsemblController();
        $response = $controller->procesarBusqueda(); // Capturamos la respuesta

        $resultados = $response['data'];
        $error = $response['error'];
        $userInput = $response['userInput'];
        break;

    case '/login':
        require_once '../src/Views/login.php';
        // Usamos exit() para que no intente cargar home.php después
        exit();

    default:
        http_response_code(404);
        echo "Error 404: Página no encontrada";
        exit();
}

require_once '../src/Views/home.php';
