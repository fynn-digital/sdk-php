<?php

declare(strict_types=1);

namespace Fynn\Sdk\V1\Checkout\Request;

class CreateProductCartRequest
{
    private string $productId;
    private ?string $debitorId;

    /**
     * @var CreateProductCartComponentRequest[]
     */
    private array $components;

    public function __construct(
        ?string $debitorId,
        string $productId
    ) {
        $this->debitorId = $debitorId;
        $this->productId = $productId;
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
            'components' => array_map(fn (CreateProductCartComponentRequest $component) => $component->toArray(), $this->components)
        ];
    }
}
