<?php
session_start();

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . '/config/config.php';

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$scriptDir = dirname($scriptName);
define('BASE_DIR', $scriptDir === '/' ? '' : $scriptDir);

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
define('BASE_URL', $protocol . '://' . $host . BASE_DIR . '/');

function asset($path)
{
    return BASE_URL . ltrim($path, '/');
}

require ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/src/router.php';
require_once ROOT_PATH . '/src/controllers/PageController.php';
require_once ROOT_PATH . '/src/controllers/AuthController.php';
require_once ROOT_PATH . '/src/controllers/AdminController.php';
require_once ROOT_PATH . '/src/utils/Icon.php';

$request_uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($request_uri, '?')) {
    $request_uri = substr($request_uri, 0, $pos);
}

$request_path = cleanPath($request_uri, BASE_DIR);

$route_config = handleRoute($request_path);

if (($route_config['auth_required'] ?? false) && !isset($_SESSION['user_id'])) {
    header('Location: ' . asset('/login'));
    exit();
}

if (($route_config['role_required'] ?? null) &&
    (!isset($_SESSION['role']) || $_SESSION['role'] !== $route_config['role_required'])
) {
    header('Location: ' . asset('/'));
    exit();
}

$pageData = [];
if (isset($route_config['controller_action']) && function_exists($route_config['controller_action'])) {
    $action = $route_config['controller_action'];
    $pageData = $action();
    if (is_array($pageData)) extract($pageData);
}

if (!isset($route_config['view'])) exit();

$viewFile = $route_config['view'];
$view_stylesheets = $route_config['stylesheets'] ?? [];
$view_path = ROOT_PATH . '/src/views/' . $viewFile;
$layout_path = ROOT_PATH . '/src/views/layout.php';

if (in_array($viewFile, ['login.php', 'create_account.php', 'password.php', 'landing.php'])) {
    if (file_exists($view_path)) require_once $view_path;
    exit();
}

if (file_exists($layout_path)) {
    $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
    $currentPage = $request_path;
    require_once $layout_path;
} else {
    if (file_exists($view_path)) require_once $view_path;
    else echo "Error crítico: Layout ni vista encontrados.";
}
