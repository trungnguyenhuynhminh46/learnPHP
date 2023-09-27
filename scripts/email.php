<?php
declare(strict_types=1);
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('STORAGE_DIR', ROOT_DIR . '/storage');
define('VIEWS_DIR', ROOT_DIR . '/views');

require_once ROOT_DIR . '/vendor/autoload.php';

use App\Container;
use App\App;
use App\Services\EmailService;

$container = new Container();
(new App($container))->boot();

$container->get(EmailService::class)->sendQueueEmails();



