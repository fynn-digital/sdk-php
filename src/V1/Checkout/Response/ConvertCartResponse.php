<?php

namespace Fynn\Sdk\V1\Checkout\Response;

class ConvertCartResponse
{
    protected array $subscriptionIds;
    protected ?string $redirectUrl;

    public function __construct(array $data)
    {
        $this->subscriptionIds = $data['subscriptionIds'] ?? [];
        $this->redirectUrl = $data['redirectUrl'] ?? null;
    }

    /**
     * @return string[]
     */
    public function getSubscriptionIds(): array
    {
        return $this->subscriptionIds;
    }

    /**
     * The redirect url will only be returned, when a payment redirect to the psp is required. Otherwise, the subscription will be created immediately and charged in background.
     */
    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }
}
