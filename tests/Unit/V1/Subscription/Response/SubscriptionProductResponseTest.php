<?php

namespace Fynn\Sdk\Unit\V1\Subscription\Response;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Subscription\Response\SubscriptionProductComponentResponse;
use Fynn\Sdk\V1\Subscription\Response\SubscriptionProductResponse;

/**
 * @covers \Fynn\Sdk\V1\Subscription\Response\SubscriptionProductResponse
 * @covers \Fynn\Sdk\V1\Subscription\Response\SubscriptionProductComponentResponse
 * @covers \Fynn\Sdk\V1\Subscription\Response\PeriodsResponse
 */
class SubscriptionProductResponseTest extends AbstractUnitTest
{
    public function testCreateFromArray(): void
    {
        $response = new SubscriptionProductResponse(
            json_decode(
                file_get_contents(__DIR__ . '/../_responses/get_subscription_products.json'),
                true
            )['data'][0]
        );

        $this->assertSame('77f1f2d4-29ea-428d-8e8c-b589441a4af5', $response->getId());
        $this->assertSame('987de151-0440-44d7-ad6b-7bbbb646a207', $response->getProductId());
        $this->assertSame('806c0681-eaef-4cdb-a1ef-fa683ff7a37b', $response->getSubscriptionId());

        $this->assertSame('2022-10-03T09:43:19+00:00', $response->getStartDate()->format(\DateTimeInterface::ATOM));
        $this->assertSame('2022-10-03T09:43:19+00:00', $response->getContractStartDate()->format(\DateTimeInterface::ATOM));
        $this->assertNull($response->getEndDate());
        $this->assertNull($response->getCustomDescription());
        $this->assertNull($response->getCancellationDate());
        $this->assertNull($response->getCostCentre());
        $this->assertNull($response->getBillingAllignmentDayOfMonth());
        $this->assertSame('2023-10-03T09:43:19+00:00', $response->getEarliestCancellationDate()->format(\DateTimeInterface::ATOM));
        $this->assertSame('Test Product', $response->getTitle());
        $this->assertSame('Some nice test product', $response->getDescription());
        $this->assertSame('12M', $response->getPeriods()->getContractPeriod());
        $this->assertSame('1M', $response->getPeriods()->getCancellationPeriod());
        $this->assertSame('12M', $response->getPeriods()->getLaterContractPeriod());
        $this->assertSame('1M', $response->getPeriods()->getLaterCancellationPeriod());
        $this->assertContainsOnlyInstancesOf(SubscriptionProductComponentResponse::class, $response->getComponents());

        $this->assertSame('79a321d6-4ca9-4c08-978e-dd4f94fc820d', $response->getComponents()[0]->getId());
        $this->assertSame('Add-On', $response->getComponents()[0]->getName());
        $this->assertSame('Standard', $response->getComponents()[0]->getVariantName());
        $this->assertSame(5, $response->getComponents()[0]->getQuantity());
        $this->assertSame('2022-10-03T09:43:19+00:00', $response->getComponents()[0]->getStartDate()->format(\DateTimeInterface::ATOM));
        $this->assertSame('2022-10-03T09:43:19+00:00', $response->getComponents()[0]->getContractStartDate()->format(\DateTimeInterface::ATOM));
        $this->assertNull($response->getComponents()[0]->getEndDate());
        $this->assertNull($response->getComponents()[0]->getCancelationDate());
        $this->assertNull($response->getComponents()[0]->getCustomDescription());
        $this->assertSame('Stück', $response->getComponents()[0]->getFeePeriodUnit());
        $this->assertSame('0', $response->getComponents()[0]->getVariantValue());
        $this->assertFalse($response->getComponents()[0]->hideFull());
        $this->assertTrue($response->getComponents()[0]->hideOnNullPrice());

        $this->assertSame('806c0681-eaef-4cdb-a1ef-fa683ff7a37b', $response->getComponents()[0]->getSubscriptionId());
        $this->assertSame('77f1f2d4-29ea-428d-8e8c-b589441a4af5', $response->getComponents()[0]->getSubscriptionProductId());
        $this->assertNull($response->getComponents()[0]->getPreviousComponentId());
        $this->assertSame('d0a7e6eb-8be7-433a-8d64-ffd750b92f49', $response->getComponents()[0]->getProductComponentId());
        $this->assertSame('b9608880-bbfc-4f99-85af-d05afb94007f', $response->getComponents()[0]->getProductComponentVariantId());
    }
}
