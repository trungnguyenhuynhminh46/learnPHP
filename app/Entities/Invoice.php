<?php
declare(strict_types=1);

namespace App\Entities;

use App\Enums\InvoiceStatus;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('invoices')]
class Invoice {
    #[Id]
    #[Column, GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $amount;

    #[Column(name: 'invoice_number')]
    private string $invoiceNumber;

    #[Column]
    private InvoiceStatus $status;

    #[Column(name: 'created_at')]
    private DateTime $createdAt;

    #[Column(name: 'due_at')]
    private DateTime $dueAt;

    #[OneToMany(mappedBy: 'invoice', targetEntity: InvoiceItem::class, cascade: ['persist', 'remove'])]
    private Collection $invoiceItems;

    public function __construct()
    {
        $this->invoiceItems = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }
 
    public function setInvoiceNumber($invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDueAt()
    {
        return $this->dueAt;
    }

    public function setDueAt($dueAt): self
    {
        $this->dueAt = $dueAt;

        return $this;
    }

    /*
    * @return Collection<InvoiceItem>
    */
    public function getInvoiceItems()
    {
        return $this->invoiceItems;
    }
 
    public function addInvoiceItem(InvoiceItem $item): self {
        $item->setInvoice($this);
        $this->invoiceItems->add($item);
        return $this;
    }
}