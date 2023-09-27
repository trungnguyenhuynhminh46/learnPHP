<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Entities\Invoice;
use App\Entities\InvoiceItem;
use App\Enums\InvoiceStatus;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
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

$paths = [__DIR__ . '/app/Entities'];

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: $paths,
    isDevMode: true,
);

$entityManager = new EntityManager($connection, $config);

// $rawInvoiceItems = [
//     ['Item 1', 1, 15],
//     ['Item 2', 2, 7.5],
//     ['Item 3', 4, 3.75]
// ];

// $invoice = new Invoice();
// $invoice->setAmount(45)
//         ->setInvoiceNumber('1')
//         ->setStatus(InvoiceStatus::Pending)
//         ->setCreatedAt(new DateTime())
//         ->setUpdatedAt(new DateTime());

// foreach($rawInvoiceItems as [$description, $quantity, $unitPrice]) {
//     $invoiceItem = new InvoiceItem();
//     $invoiceItem->setDescription($description)
//                 ->setQuantity($quantity)
//                 ->setUnitPrice($unitPrice);

//     $invoice->addInvoiceItem($invoiceItem);
//     $entityManager->persist($invoiceItem);
// }
// $entityManager->persist($invoice);
// $entityManager->flush();

$queryBuilder = $entityManager->createQueryBuilder();

// WHERE amount > :amount AND (status = :status OR created_at >= :date)

$query = $queryBuilder
        ->select('i', 'it.description')
        ->from(Invoice::class, 'i')
        ->join('i.invoiceItems', 'it')
        ->where(
            $queryBuilder->expr()->andX(
                $queryBuilder->expr()->gt('i.amount', ':amount'),
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('i.status', ':status'),
                    $queryBuilder->expr()->gte('i.createdAt', ':date')
                )
            )
        )
        ->setParameter('amount', 20)
        ->setParameter('status', InvoiceStatus::Pending->value)
        ->setParameter('date', new DateTime('2021-01-01'))
        ->getQuery();

$results = $query->getResult();
// Get number of results
var_dump(count($results));
foreach($results as [$invoice, $description]) {
    echo $invoice->getCreatedAt()->format('Y-m-d H:i:s')
        . ' - ' . $invoice->getAmount()
        . ' - ' . $invoice->getStatus()->toString()
        . PHP_EOL;
    // var_dump($invoiceItem);
    var_dump($description);
}
?>