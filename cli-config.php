<?php

require 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connectionParams = [
    'host' => $_ENV['DB_HOST'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'dbname' => $_ENV['DB_DATABASE'],
    'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql'
];

$connection = DriverManager::getConnection($connectionParams);

$config = new PhpFile('migrations.php'); 

$paths = [__DIR__ . '/app/Entities'];;
$isDevMode = true;

$ORMconfig = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$entityManager = new EntityManager($connection, $ORMconfig);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));