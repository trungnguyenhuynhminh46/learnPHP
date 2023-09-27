<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
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
        // $invoices = Invoice::query()
        //     ->where('status', InvoiceStatus::Paid)
        //     ->get()
        //     ->map(fn(Invoice $invoice)=>[
        //         'id' => $invoice->id,
        //         'invoiceNumber' => $invoice->invoice_number,
        //         'amount' => $invoice->amount,
        //         'status' => $invoice->status->value,
        //         'dueDate' => $invoice->due_date->toDateTimeString(),
        //     ])->toArray();
        $invoices = [
            [
                'id' => 1,
                'invoiceNumer' => 1,
                'amount' => 1000,
                'status' => 1,
                'dueDate' => '2021-10-10 10:10:10',
            ],
            [
                'id' => 2,
                'invoiceNumer' => 1,
                'amount' => 2000,
                'status' => 1,
                'dueDate' => '2021-10-10 10:10:10',
            ],
            [
                'id' => 3,
                'invoiceNumer' => 1,
                'amount' => 3000,
                'status' => 1,
                'dueDate' => '2021-10-10 10:10:10',
            ],
        ];
        return $this->twig->render('invoices/index.twig', compact('invoices'));
    }
}
