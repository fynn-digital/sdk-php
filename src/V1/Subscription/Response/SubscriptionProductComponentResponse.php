<?php

namespace Fynn\Sdk\V1\Subscription\Response;

class SubscriptionProductComponentResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): string
    {
        return $this->data['subscriptionProductComponentId'];
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->data['startDate'] ? new \DateTimeImmutable($this->data['startDate']) : null;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->data['endDate'] ? new \DateTimeImmutable($this->data['endDate']) : null;
    }

    public function getProductComponentId(): string
    {
        return $this->data['originProductComponentId'];
    }

    public function getProductComponentVariantId(): string
    {
        return $this->data['originProductComponentVariantId'];
    }

    public function getFeePeriodUnit(): string
    {
        return $this->data['feePeriodUnit'];
    }

    public function getVariantValue(): string
    {
        return $this->data['variantValue'];
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getSubscriptionId(): string
    {
        return $this->data['subscriptionId'];
    }

    public function getSubscriptionProductId(): string
    {
        return $this->data['subscriptionProductId'];
    }

    public function getQuantity(): int
    {
        return $this->data['quantity'];
    }

    public function getCustomDescription(): ?string
    {
        return $this->data['customDescription'] ?? null;
    }

    public function getCancelationDate(): ?\DateTimeImmutable
    {
        return $this->data['cancellationDate'] ? new \DateTimeImmutable($this->data['cancellationDate']) : null;
    }

    public function hideFull(): bool
    {
        return $this->data['hideFull'];
    }

    public function hideOnNullPrice(): bool
    {
        return $this->data['hideOnNullPrice'];
    }

    public function getPreviousComponentId(): ?string
    {
        return $this->data['previousComponentId'] ?? null;
    }

    public function getVariantName(): ?string
    {
        return $this->data['variantName'] ?? null;
    }

    public function getContractStartDate(): ?\DateTimeImmutable
    {
        return $this->data['contractStartDate'] ? new \DateTimeImmutable($this->data['contractStartDate']) : null;
    }
}
