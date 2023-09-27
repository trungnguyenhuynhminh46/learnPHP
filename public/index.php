<?php
declare(strict_types=1);
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('STORAGE_DIR', ROOT_DIR . '/storage');
define('VIEWS_DIR', ROOT_DIR . '/views');

require_once __DIR__ . '/../vendor/autoload.php';
require_once APP_DIR . '/helpers/index.php';

use App\App;
use App\Router;
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use Illuminate\Container\Container;

$container = new Container();
$router = new Router($container);

$router->registerRoutesThroughAttributes([
    HomeController::class,
    InvoiceController::class,
]);
$request = [
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD'],
];

(new App($container, $router, $request))->boot()->run();
?>