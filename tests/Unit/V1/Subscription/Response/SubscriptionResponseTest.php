<?php

namespace Fynn\Sdk\Unit\V1\Subscription\Response;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Subscription\Response\SubscriptionResponse;

class SubscriptionResponseTest extends AbstractUnitTest
{
    public function testCreateFromArray(): void
    {
        $subscription = new SubscriptionResponse(
            json_decode(file_get_contents(__DIR__ . '/../_responses/get_subscription.json'), true)['data']
        );

        $this->assertSame('806c0681-eaef-4cdb-a1ef-fa683ff7a37b', $subscription->getSubscriptionId());
        $this->assertSame('af3f7f74-a993-4189-bf89-2bbb4cdba19b', $subscription->getDebitorId());
        $this->assertSame('STATUS_ACTIVE', $subscription->getStatus());
        $this->assertNull($subscription->getTrialEndsOn());
        $this->assertSame(['77f1f2d4-29ea-428d-8e8c-b589441a4af5'], $subscription->getSubscriptionProductIds());
        $this->assertNull($subscription->getBillingPeriod());
        $this->assertNull($subscription->getBillingAllignmentDayOfMonth());
        $this->assertNull($subscription->getCancellationDate());
        $this->assertNull($subscription->getAlias());
        $this->assertSame('f81ca9a2-c338-481c-8bd6-68b730df51f6', $subscription->getPaymentMethodId());
        $this->assertSame('ff6d6c02-d770-4f55-8776-d22fd6cf08f5', $subscription->getInvoiceAddressId());
        $this->assertSame('4U8DL8PYLQ', $subscription->getDocumentNumber());
        $this->assertSame('2022-10-05T17:33:05+00:00', $subscription->getCreatedAt()->format(\DateTimeInterface::ATOM));
    }
}
