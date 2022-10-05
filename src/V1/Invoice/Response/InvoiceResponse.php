<?php

namespace Fynn\Sdk\V1\Invoice\Response;

use Fynn\Sdk\V1\Api\Response\MoneyResponse;

class InvoiceResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): string
    {
        return $this->data['invoiceId'];
    }

    public function getInvoiceNumber(): string
    {
        return $this->data['documentId'];
    }

    public function getPaymentMethodId(): ?string
    {
        return $this->data['paymentMethodId'] ?? null;
    }

    public function getFinalizationDate(): ?\DateTimeImmutable
    {
        return isset($this->data['finalizationDate']) ? new \DateTimeImmutable($this->data['finalizationDate']) : null;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return isset($this->data['dueDate']) ? new \DateTimeImmutable($this->data['dueDate']) : null;
    }

    public function getReceiverAddressId(): string
    {
        return $this->data['receiverAddressId'];
    }

    public function getDebitorId(): string
    {
        return $this->data['debitorId'];
    }

    public function getInvoiceType(): string
    {
        return $this->data['invoiceType'];
    }

    /**
     * @return string One of: STATUS_PAID, STATUS_UNPAID, STATUS_REMINDED, STATUS_CANCELLED, STATUS_DRAFT
     */
    public function getStatus(): string
    {
        return $this->data['status'];
    }

    public function getNotice(): ?string
    {
        return $this->data['notice'] ?? null;
    }

    public function getCurrencyCode(): string
    {
        return $this->data['currencyCode'];
    }

    public function getNetAmount(): ?MoneyResponse
    {
        return isset($this->data['netAmount']) ? new MoneyResponse($this->data['netAmount']) : null;
    }

    public function getGrossAmount(): ?MoneyResponse
    {
        return isset($this->data['grossAmount']) ? new MoneyResponse($this->data['grossAmount']) : null;
    }

    public function getTaxAmount(): ?MoneyResponse
    {
        return isset($this->data['taxAmount']) ? new MoneyResponse($this->data['taxAmount']) : null;
    }

    public function getPdfUrl(): ?string
    {
        return $this->data['pdfUrl'] ?? null;
    }
}
