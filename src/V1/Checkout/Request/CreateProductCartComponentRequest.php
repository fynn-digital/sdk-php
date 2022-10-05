<?php

declare(strict_types=1);

namespace Fynn\Sdk\V1\Checkout\Request;

class CreateProductCartComponentRequest
{
    public function __construct(
        private readonly string $productComponentId,
        private readonly string $productComponentVariantId,
        private readonly int $quantity
    ) {
    }

    public function toArray(): array
    {
        return [
            'productComponentId' => $this->productComponentId,
            'productComponentVariantId' => $this->productComponentVariantId,
            'quantity' => $this->quantity
        ];
    }
}
