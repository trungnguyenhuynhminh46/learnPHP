<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use Twig\Environment;

class InvoiceController
{
    public function __construct(private Environment $twig){}
    #[Get('/test')]
    public function test(): string
    {
        return "Test";
    }

    #[Get('/invoices')]
    public function index(): string
    {
        $invoices = Invoice::query()
            ->where('status', InvoiceStatus::Paid)
            ->get()
            ->map(fn(Invoice $invoice)=>[
                'id' => $invoice->id,
                'invoiceNumber' => $invoice->invoice_number,
                'amount' => $invoice->amount,
                'status' => $invoice->status->value,
                'dueDate' => $invoice->due_date->toDateTimeString(),
            ])->toArray();
            
        return "Invoices";
        // return $this->twig->render('invoices/index.twig', compact('invoices'));
    }
}
