<?php
declare(strict_types=1);
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('STORAGE_DIR', ROOT_DIR . '/storage');
define('VIEWS_DIR', ROOT_DIR . '/views');

require_once __DIR__ . '/../vendor/autoload.php';
require_once APP_DIR . '/helpers/index.php';

use Slim\Factory\AppFactory;
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Extra\Intl\IntlExtension;
use DI\Container;
use Doctrine\ORM\EntityManager;
use App\Config;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use function DI\create;

require __DIR__ . '/../vendor/autoload.php';

// ==== NOTE khúc này
(Dotenv\Dotenv::createImmutable(ROOT_DIR))->safeLoad();
$container = new Container();
$container->set(Config::class, create(Config::class)->constructor($_ENV));
$container->set(EntityManager::class, function (Config $config) {
    $paths = [APP_DIR . '/Entities'];
    $isDevMode = false;
    $dbParams = $config->db;

    $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
    $connection = DriverManager::getConnection($dbParams, $config);
    $entityManager = new EntityManager($connection, $config);
    return $entityManager;
});
// ====
AppFactory::setContainer($container);
$app = AppFactory::create();
$twig = Twig::create(VIEWS_DIR, [
    'cache' => STORAGE_DIR.'/cache',
    'auto_reload' => true
]);
$twig->addExtension(new IntlExtension);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', [HomeController::class, 'index']);
$app->get('/invoices', [InvoiceController::class, 'view']);

$app->run();
?>