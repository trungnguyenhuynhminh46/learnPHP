<?php
declare(strict_types=1);

namespace App\Contracts;

interface PaymentGatewayServiceInterface {
    public function charge(array $customer, float $amount, float $tax): bool;
}