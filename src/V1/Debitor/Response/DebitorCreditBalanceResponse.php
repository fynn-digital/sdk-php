<?php

namespace Fynn\Sdk\V1\Debitor\Response;

class DebitorCreditBalanceResponse
{
    protected int $precision;
    protected int $amount;
    protected string $currencyCode;

    public function __construct(array $data)
    {
        $this->precision = $data['precision'];
        $this->amount = $data['amount'];
        $this->currencyCode = $data['currencyCode'];
    }

    public function getAmount(): mixed
    {
        return $this->amount;
    }

    public function getCurrencyCode(): mixed
    {
        return $this->currencyCode;
    }

    public function getPrecision(): mixed
    {
        return $this->precision;
    }
}
