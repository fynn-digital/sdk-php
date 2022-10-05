<?php

namespace Fynn\Sdk\V1\Subscription\Request;

class ChangeSubscriptionComponentQuantityRequest
{
    protected int $quantity;
    protected ?\DateTimeInterface $changeOn;

    public function __construct(
        int $quantity,
        ?\DateTimeInterface $changeOn = null,
    ) {
        $this->quantity = $quantity;
        $this->changeOn = $changeOn;
    }

    public function toArray(): array
    {
        return [
            'quantity' => $this->quantity,
            'startDate' => $this->changeOn?->format(\DateTimeInterface::ATOM),
        ];
    }
}
