<?php

namespace Fynn\Sdk\V1\Subscription\Request;

class ExtendSubscriptionTrialRequest
{
    private string $trialPeriod;

    public function __construct(string $trialPeriod)
    {
        if (!preg_match('/^(\d+Y)?(\d+M)?(\d+W)?(\d+D)?(\d+H)?(\d+I)?(\d+S)?$/', $trialPeriod)) {
            throw new \InvalidArgumentException('Invalid trial period');
        }

        $this->trialPeriod = $trialPeriod;
    }

    public function toArray(): array
    {
        return [
            'period' => $this->trialPeriod
        ];
    }
}
