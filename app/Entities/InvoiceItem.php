<?php
declare(strict_types=1);

namespace App\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table('invoice_items')]
class InvoiceItem {
    #[Id]
    #[Column(), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name: 'invoice_id')]
    private int $invoiceId;

    #[Column]
    private string $description;

    #[Column]
    private int $quantity;

    #[Column(name: 'unit_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $unitPrice;

    #[ManyToOne(targetEntity: Invoice::class, inversedBy: 'invoiceItems')]
    private Invoice $invoice;
    
    public function getId()
    {
        return $this->id;
    }
 
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
 
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    public function setInvoiceId($invoiceId): self
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
 
    public function setUnitPrice($unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getInvoice()
    {
        return $this->invoice;
    }
 
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }
}