<?php

namespace Fynn\Sdk\V1\Subscription\Response;

class PeriodsResponse
{
    protected string $cancellationPeriod;
    protected string $laterCancellationPeriod;
    protected string $contractPeriod;
    protected string $laterContractPeriod;

    public function __construct(
        string $cancellationPeriod,
        string $laterCancellationPeriod,
        string $contractPeriod,
        string $laterContractPeriod
    ) {
        $this->cancellationPeriod = $cancellationPeriod;
        $this->laterCancellationPeriod = $laterCancellationPeriod;
        $this->contractPeriod = $contractPeriod;
        $this->laterContractPeriod = $laterContractPeriod;
    }

    public function getCancellationPeriod(): string
    {
        return $this->cancellationPeriod;
    }

    public function getLaterCancellationPeriod(): string
    {
        return $this->laterCancellationPeriod;
    }

    public function getContractPeriod(): string
    {
        return $this->contractPeriod;
    }

    public function getLaterContractPeriod(): string
    {
        return $this->laterContractPeriod;
    }
}
