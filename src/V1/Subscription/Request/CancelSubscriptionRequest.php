<?php

namespace Fynn\Sdk\V1\Subscription\Request;

class CancelSubscriptionRequest
{
    private \DateTimeInterface $cancelDate;

    public function __construct(\DateTimeInterface $cancelDate)
    {
        $this->cancelDate = $cancelDate;
    }

    public function toArray(): array
    {
        return [
            'endDate' => $this->cancelDate->format(\DateTimeInterface::ATOM)
        ];
    }
}
