<?php

declare(strict_types=1);

namespace Fynn\Sdk\V1\Checkout\Request;

class CreateProductCartRequest
{
    private string $productId;
    private ?string $debitorId;
    private ?string $trialPeriod;

    /**
     * @var CreateProductCartComponentRequest[]
     */
    private array $components;

    public function __construct(
        ?string $debitorId,
        string $productId,
        ?string $trialPeriod = null
    ) {
        $this->debitorId = $debitorId;
        $this->productId = $productId;
        $this->trialPeriod = $trialPeriod;
        $this->components = [];
    }

    public function addComponent(CreateProductCartComponentRequest $component): void
    {
        $this->components[] = $component;
    }

    public function toArray(): array
    {
        return [
            'productId' => $this->productId,
            'debitorId' => $this->debitorId,
            'components' => array_map(fn (CreateProductCartComponentRequest $component) => $component->toArray(), $this->components),
            'trialPeriod' => $this->trialPeriod
        ];
    }
}
