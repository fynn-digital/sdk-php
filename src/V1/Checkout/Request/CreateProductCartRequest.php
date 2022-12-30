<?php

declare(strict_types=1);

namespace Fynn\Sdk\V1\Checkout\Request;

class CreateProductCartRequest
{
    private ?string $customDescription;
    private string $productId;
    private ?string $debitorId;
    private ?string $trialPeriod;
    private ?string $redirectUrl;
    private string $label;

    /**
     * @var CreateProductCartComponentRequest[]
     */
    private array $components;

    public function __construct(
        ?string $debitorId,
        string $productId,
        ?string $trialPeriod = null,
        ?string $customDescription = null,
        ?string $redirectUrl = null,
        string $label = 'default'
    ) {
        $this->debitorId = $debitorId;
        $this->productId = $productId;
        $this->trialPeriod = $trialPeriod;
        $this->components = [];
        $this->customDescription = $customDescription;
        $this->redirectUrl = $redirectUrl;
        $this->label = $label;
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
            'trialPeriod' => $this->trialPeriod,
            'customDescription' => $this->customDescription,
            'redirectUrl' => $this->redirectUrl,
            'label' => $this->label,
        ];
    }
}
