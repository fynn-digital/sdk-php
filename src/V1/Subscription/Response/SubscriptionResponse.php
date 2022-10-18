<?php

namespace Fynn\Sdk\V1\Subscription\Response;

class SubscriptionResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getSubscriptionId(): string
    {
        return $this->data['subscriptionId'];
    }

    public function getDebitorId(): string
    {
        return $this->data['debitorId'];
    }

    /**
     * @return string One of: 'STATUS_ACTIVE', 'STATUS_PAUSED', 'STATUS_CANCELLED'
     */
    public function getStatus(): string
    {
        return $this->data['status'];
    }

    public function getAlias(): ?string
    {
        return $this->data['alias'] ?? null;
    }

    /**
     * The billing period which overrides all other billing periods of the selected products.
     *
     * @return string|null
     */
    public function getBillingPeriod(): ?string
    {
        return $this->data['billingPeriod'] ?? null;
    }

    /**
     * The billing allignment day of month which overrides all other allignments of the selected products.
     *
     * @return string|null
     */
    public function getBillingAllignmentDayOfMonth(): ?int
    {
        return $this->data['billingAllignmentDayOfMonth'] ?? null;
    }

    public function getDocumentNumber(): ?string
    {
        return $this->data['documentNumber'] ?? null;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->data['createdAt']);
    }

    public function getInvoiceAddressId(): ?string
    {
        return $this->data['invoiceAddressId'] ?? null;
    }

    public function getPaymentMethodId(): ?string
    {
        return $this->data['paymentMethodId'] ?? null;
    }

    /**
     * @return array<string>
     */
    public function getSubscriptionProductIds(): array
    {
        return $this->data['subscriptionProductIds'];
    }

    public function getTrialEndsOn(): ?\DateTimeImmutable
    {
        return $this->data['trialEndsOn'] ? new \DateTimeImmutable($this->data['trialEndsOn']) : null;
    }

    /**
     * Date when subscription was cancelled.
     */
    public function getCancellationDate(): ?\DateTimeImmutable
    {
        return $this->data['cancellationDate'] ? new \DateTimeImmutable($this->data['cancellationDate']) : null;
    }
}
