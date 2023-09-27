<?php
declare(strict_types=1);

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\InvoiceService;
use App\Services\EmailService;
use App\Services\PaymentGatewayService;
use App\Services\SalesTaxService;

class InvoiceServiceTest extends TestCase
{
    /** @test */
    public function it_can_process_an_invoice(): void
    {
        $customer = [
            'name'=>'Nguyễn Huỳnh Minh Trung'
        ];
        $amount = 1000;
        $paymentGatewayObserver = $this->createMock(PaymentGatewayService::class);
        $salesTaxObserver = $this->createMock(SalesTaxService::class);
        $emailObserver = $this->createMock(EmailService::class);

        $paymentGatewayObserver
            ->method('charge')
            ->willReturn(true);

        $invoice = new InvoiceService(
            $paymentGatewayObserver,
            $salesTaxObserver,
            $emailObserver
        );

        $proccess_result = $invoice->process($customer, $amount);
        $this->assertTrue($proccess_result);
    }

    /** test */
    public function it_sends_an_email_when_invoice_is_proccessed(): void
    {
        $customer = [
            'name' => 'Nguyễn Huỳnh Minh Trung'
        ];
        $amount = 1000;

        $paymentGatewayObserver = $this->createMock(PaymentGatewayService::class);
        $salesTaxObserver = $this->createMock(SalesTaxService::class);
        $emailObserver = $this->createMock(EmailService::class);

        $paymentGatewayObserver
            ->method('charge')
            ->willReturn(true);

        $emailObserver
            ->expect($this->once())
            ->method('sendEmail')
            ->with($customer, 'receipt');

        $invoice = new InvoiceService(
            $paymentGatewayObserver,
            $salesTaxObserver,
            $emailObserver
        );

        $proccess_result = $invoice->process($customer, $amount);
        $this->assertTrue($proccess_result);
    }
}