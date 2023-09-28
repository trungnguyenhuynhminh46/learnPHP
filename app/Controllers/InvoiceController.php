<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Enums\InvoiceStatus;
use App\Services\InvoiceService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class InvoiceController
{
    public function __construct(private InvoiceService $invoiceService) {}
    public function view(Request $request, Response $response, $args) {
        $view = Twig::fromRequest($request);
        $invoices = $this->invoiceService->getInvoices(InvoiceStatus::Paid);
        return $view->render($response, 'invoices/index.twig', compact('invoices'));
    }
}
