<?php

namespace Unit\V1\Checkout;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Checkout\CartService;
use GuzzleHttp\Psr7\Response;

class CartServiceTest extends AbstractUnitTest
{
    public function testRemoveCart(): void
    {
        $responses = [
            new Response(200)
        ];
        $history = [];
        $client = $this->buildClient($responses, $history);

        $cartService = new CartService($client);
        $cartService->removeCart('cart_id');

        $this->assertCount(1, $history);
        $this->assertEquals('DELETE', $history[0]['request']->getMethod());
        $this->assertEquals('/api/v1/checkout/cart/cart_id', $history[0]['request']->getUri()->getPath());
    }

    public function testConvertCartRequiresRedirectToPaymentServiceProvider(): void
    {
        $responses = [
            new Response(202, [], json_encode([
                'data' => [
                    'redirectUrl' => 'https://psp.com/redirect',
                ]
            ]))
        ];

        $history = [];
        $client = $this->buildClient($responses, $history);

        $cartService = new CartService($client);
        $response = $cartService->convertCart('cart_id');

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/v1/checkout/cart/cart_id/order', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('XMLHttpRequest', $history[0]['request']->getHeader('X-Requested-With')[0]);

        $this->assertEquals('https://psp.com/redirect', $response->getRedirectUrl());
        $this->assertCount(0, $response->getSubscriptionIds());
    }

    public function testConvertCartGeneratesASubscriptionAndAutoChargesInBackground(): void
    {
        $responses = [
            new Response(202, [], json_encode([
                'data' => [
                    'subscriptionIds' => [
                        'ad8d8d8d-8d8d-8d8d-8d8d-8d8d8d8d8d8d',
                    ]
                ]
            ]))
        ];

        $history = [];
        $client = $this->buildClient($responses, $history);

        $cartService = new CartService($client);
        $response = $cartService->convertCart('cart_id');

        $this->assertCount(1, $history);
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('/api/v1/checkout/cart/cart_id/order', $history[0]['request']->getUri()->getPath());
        $this->assertEquals('XMLHttpRequest', $history[0]['request']->getHeader('X-Requested-With')[0]);

        $this->assertNull($response->getRedirectUrl());
        $this->assertCount(1, $response->getSubscriptionIds());
        $this->assertEquals('ad8d8d8d-8d8d-8d8d-8d8d-8d8d8d8d8d8d', $response->getSubscriptionIds()[0]);
    }
}
