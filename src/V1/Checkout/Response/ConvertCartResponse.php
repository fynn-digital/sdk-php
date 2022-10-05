<?php

namespace Fynn\Sdk\V1\Checkout\Response;

class ConvertCartResponse
{
    protected string $subscriptionIds;

    public function __construct(array $data)
    {
        $this->subscriptionIds = $data['subscriptionIds'];
    }

    /**
     * @return string[]
     */
    public function getSubscriptionIds(): array
    {
        return $this->subscriptionIds;
    }
}
