<?php

namespace Fynn\Sdk\V1\Subscription\Response;

class SubscriptionProductResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): string
    {
        return $this->data['subscriptionProductId'];
    }

    public function getProductId(): string
    {
        return $this->data['originProductId'];
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->data['endDate'] ? new \DateTimeImmutable($this->data['endDate']) : null;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->data['startDate']);
    }

    public function getTitle(): string
    {
        return $this->data['title'];
    }

    public function getDescription(): string
    {
        return $this->data['description'];
    }

    public function getCustomDescription(): ?string
    {
        return $this->data['customDescription'] ?? null;
    }

    public function getCancellationDate(): ?\DateTimeImmutable
    {
        return $this->data['cancellationDate'] ? new \DateTimeImmutable($this->data['cancellationDate']) : null;
    }

    public function getEarliestCancellationDate(): ?\DateTimeImmutable
    {
        return $this->data['earliestCancellationDate'] ? new \DateTimeImmutable($this->data['earliestCancellationDate']) : null;
    }

    public function getContractStartDate(): ?\DateTimeImmutable
    {
        return $this->data['contractStartDate'] ? new \DateTimeImmutable($this->data['contractStartDate']) : null;
    }

    public function getCostCentre(): ?string
    {
        return $this->data['costCentre'] ?? null;
    }

    public function getPeriods(): PeriodsResponse
    {
        return new PeriodsResponse(
            $this->data['cancellationPeriod'],
            $this->data['laterCancellationPeriod'],
            $this->data['contractPeriod'],
            $this->data['laterContractPeriod']
        );
    }

    public function getSubscriptionId(): string
    {
        return $this->data['subscriptionId'];
    }

    public function getQuantity(): int
    {
        return $this->data['quantity'];
    }

    public function getBillingAllignmentDayOfMonth(): ?int
    {
        return $this->data['billingAllignmentDayOfMonth'];
    }

    /**
     * @return SubscriptionProductComponentResponse[]
     */
    public function getComponents(): array
    {
        return array_map(function (array $component) {
            return new SubscriptionProductComponentResponse($component);
        }, $this->data['components'] ?? $this->data['productComponents'] ?? []);
    }
}
