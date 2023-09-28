<?php
declare(strict_types=1);

namespace App\Services;
use App\Enums\InvoiceStatus;
use App\Entities\Invoice;
use App\Repositories\InvoiceRepository;

class InvoiceService {
    public function __construct(private InvoiceRepository $invoiceRepository) {}
    public function getInvoices(InvoiceStatus $status = InvoiceStatus::Pending) {
        return $this->invoiceRepository->getInvoices($status);
    }
}