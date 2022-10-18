<?php

namespace Fynn\Sdk\V1\Api\Response;

class MoneyResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getAmount(): int
    {
        return $this->data['amount'];
    }

    public function getCurrencyCode(): string
    {
        return $this->data['currencyCode'];
    }

    public function getPrecision(): int
    {
        return $this->data['precision'];
    }

    public function getCentAmount(): float
    {
        return $this->data['amount'] / pow(10, $this->data['precision'] - 2);
    }
}
