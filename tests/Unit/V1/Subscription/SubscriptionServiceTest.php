<?php

namespace Fynn\Sdk\Unit\V1\Subscription;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Subscription\Request\CancelSubscriptionRequest;
use Fynn\Sdk\V1\Subscription\Request\ChangeSubscriptionComponentQuantityRequest;
use Fynn\Sdk\V1\Subscription\Request\ExtendSubscriptionTrialRequest;
use Fynn\Sdk\V1\Subscription\Response\SubscriptionProductResponse;
use Fynn\Sdk\V1\Subscription\SubscriptionService;
use GuzzleHttp\Psr7\Response;

/**
 * @covers \Fynn\Sdk\V1\Subscription\SubscriptionService
 */
class SubscriptionServiceTest extends AbstractUnitTest
{
    public function testCancelSubscription(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $service = new SubscriptionService($client);
        $service->cancelSubscription('58994723-9b53-4eed-bfb6-13173c6ec67d', new CancelSubscriptionRequest(new \DateTimeImmutable('2021-01-01')));

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscriptions/58994723-9b53-4eed-bfb6-13173c6ec67d/cancel', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('{"endDate":"2021-01-01T00:00:00+00:00"}', $history[0]['request']->getBody()->getContents());
    }

    public function testGetSubscription(): void
    {
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/get_subscription.json')
        ];

        $history = [];

        $client = $this->buildClient($responses, $history);

        $service = new SubscriptionService($client);
        $subscription = $service->getSubscription('806c0681-eaef-4cdb-a1ef-fa683ff7a37b');

        $this->assertCount(1, $history);
        $this->assertSame('GET', $history[0]['request']->getMethod());
        $this->assertSame('/api/subscriptions/806c0681-eaef-4cdb-a1ef-fa683ff7a37b', $history[0]['request']->getUri()->getPath());

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

    public function testPauseSubscription(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $service = new SubscriptionService($client);
        $service->pauseSubscription('58994723-9b53-4eed-bfb6-13173c6ec67d');

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscriptions/58994723-9b53-4eed-bfb6-13173c6ec67d/pause', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('', $history[0]['request']->getBody()->getContents());
    }

    public function testResumeSubscription(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $service = new SubscriptionService($client);
        $service->resumeSubscription('58994723-9b53-4eed-bfb6-13173c6ec67d');

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscriptions/58994723-9b53-4eed-bfb6-13173c6ec67d/activate', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('', $history[0]['request']->getBody()->getContents());
    }

    public function testChangeSubscriptionComponentQuantity(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $request = new ChangeSubscriptionComponentQuantityRequest(2, new \DateTimeImmutable('2021-01-01'));

        $service = new SubscriptionService($client);
        $service->changeSubscriptionComponentQuantity('58994723-9b53-4eed-bfb6-13173c6ec67d', $request);

        $this->assertCount(1, $history);
        $this->assertEquals('PUT', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscription-product-components/58994723-9b53-4eed-bfb6-13173c6ec67d/quantity', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('{"quantity":2,"startDate":"2021-01-01T00:00:00+00:00"}', $history[0]['request']->getBody()->getContents());
    }

    public function testChangeSubscriptionComponentQuantityWithoutEndDate(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $request = new ChangeSubscriptionComponentQuantityRequest(2, null);

        $service = new SubscriptionService($client);
        $service->changeSubscriptionComponentQuantity('58994723-9b53-4eed-bfb6-13173c6ec67d', $request);

        $this->assertCount(1, $history);
        $this->assertEquals('PUT', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscription-product-components/58994723-9b53-4eed-bfb6-13173c6ec67d/quantity', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('{"quantity":2,"startDate":null}', $history[0]['request']->getBody()->getContents());
    }

    public function testGetSubscriptionProducts(): void
    {
        $responses = [
            new Response(200, [], file_get_contents(__DIR__ . '/_responses/get_subscription_products.json'))
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $service = new SubscriptionService($client);
        $subscriptionProducts = $service->getSubscriptionProducts('806c0681-eaef-4cdb-a1ef-fa683ff7a37b');

        $this->assertCount(1, $history);
        $this->assertSame('GET', $history[0]['request']->getMethod());
        $this->assertSame('/api/subscriptions/806c0681-eaef-4cdb-a1ef-fa683ff7a37b/products', $history[0]['request']->getUri()->getPath());

        $this->assertCount(1, $subscriptionProducts);
        $this->assertContainsOnlyInstancesOf(SubscriptionProductResponse::class, $subscriptionProducts);
    }

    public function testExtendTrial(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $request = new ExtendSubscriptionTrialRequest('1M');
        $service = new SubscriptionService($client);
        $service->extendTrial('58994723-9b53-4eed-bfb6-13173c6ec67d', $request);

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscriptions/58994723-9b53-4eed-bfb6-13173c6ec67d/trial/extend', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('{"period":"1M"}', $history[0]['request']->getBody()->getContents());
    }

    public function testCancelTrial(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $service = new SubscriptionService($client);
        $service->cancelTrial('58994723-9b53-4eed-bfb6-13173c6ec67d');

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscriptions/58994723-9b53-4eed-bfb6-13173c6ec67d/trial/cancel', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('', $history[0]['request']->getBody()->getContents());
    }

    public function testActivateSubscriptionWithoutTrial(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $service = new SubscriptionService($client);
        $service->activateSubscription('58994723-9b53-4eed-bfb6-13173c6ec67d');

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscriptions/58994723-9b53-4eed-bfb6-13173c6ec67d/activate', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('{"trialPeriod":null}', $history[0]['request']->getBody()->getContents());
    }

    public function testActivateSubscriptionWithTrial(): void
    {
        $responses = [
            new Response(201)
        ];
        $history = [];

        $client = $this->buildClient($responses, $history);

        $service = new SubscriptionService($client);
        $service->activateSubscription('58994723-9b53-4eed-bfb6-13173c6ec67d', '1M');

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/subscriptions/58994723-9b53-4eed-bfb6-13173c6ec67d/activate', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('{"trialPeriod":"1M"}', $history[0]['request']->getBody()->getContents());
    }
}
