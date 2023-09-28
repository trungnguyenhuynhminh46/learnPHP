<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Invoice;
use App\Enums\InvoiceStatus;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class InvoiceRepository {
    private QueryBuilder $queryBuilder;
    public function __construct(private EntityManager $em) {
        $this->queryBuilder = $this->em->createQueryBuilder();
    }
        
    public function getInvoices(InvoiceStatus $status = InvoiceStatus::Pending) {
        return $this->queryBuilder->select('i')
            ->from(Invoice::class, 'i')
            ->where('i.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getArrayResult();
    }
}
?>