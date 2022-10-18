<?php

namespace Fynn\Sdk\Unit\V1\Checkout;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Checkout\CartProductService;
use Fynn\Sdk\V1\Checkout\Request\CreateProductCartComponentRequest;
use Fynn\Sdk\V1\Checkout\Request\CreateProductCartRequest;
use Fynn\Sdk\V1\Checkout\Response\CreateCartResponse;
use GuzzleHttp\Psr7\Response;

class CartProductServiceTest extends AbstractUnitTest
{
    public function testCreateProductCart(): void
    {
        $history = [];
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/create_product_cart.json'),
        ];

        $client = $this->buildClient($responses, $history);

        $cartProductService = new CartProductService($client);

        $request = new CreateProductCartRequest('f1d7d286-b88b-4849-9cb3-e30dc22f9747', '58994723-9b53-4eed-bfb6-13173c6ec67d', '14D');
        $request->addComponent(new CreateProductCartComponentRequest(
            'd0a7e6eb-8be7-433a-8d64-ffd750b92f49',
            'b9608880-bbfc-4f99-85af-d05afb94007f',
            1
        ));
        $response = $cartProductService->createProductCart($request);

        $this->assertCount(1, $history);
        $this->assertSame('POST', $history[0]['request']->getMethod());
        $this->assertSame('/api/v1/checkout/cart-product', $history[0]['request']->getUri()->getPath());
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/_requests/create_product_cart.json', $history[0]['request']->getBody()->getContents());

        $this->assertSame('cart_2GJ54fACW7H0fYqWs6ZXUnwjN2T', $response->getCartId());
        $this->assertSame('Ieuhp2bj45SXIqgHiAZf5iKSIPN2GJ54lkLb89niWqBtB8bH82X8Ane0fbd05b710f75da1e5c90bc261f2e560d43efa9', $response->getCartAuthenticationToken());
    }

    public function testGenerateProductionCartLink(): void
    {
        $history = [];
        $cartProductService = new CartProductService($this->buildClient([], $history));

        $response = new CreateCartResponse(json_decode(file_get_contents(__DIR__ . '/_responses/create_product_cart.json'), true)['data']);
        $link = $cartProductService->generateCartLink($response, 'username', false);

        $this->assertSame('https://username.customerfront.app/checkout/cart?c=Ieuhp2bj45SXIqgHiAZf5iKSIPN2GJ54lkLb89niWqBtB8bH82X8Ane0fbd05b710f75da1e5c90bc261f2e560d43efa9', $link);
    }

    public function testGenerateSandboxCartLink(): void
    {
        $history = [];
        $cartProductService = new CartProductService($this->buildClient([], $history));

        $response = new CreateCartResponse(json_decode(file_get_contents(__DIR__ . '/_responses/create_product_cart.json'), true)['data']);
        $link = $cartProductService->generateCartLink($response, 'username', true);

        $this->assertSame('https://username.sandbox.customerfront.app/checkout/cart?c=Ieuhp2bj45SXIqgHiAZf5iKSIPN2GJ54lkLb89niWqBtB8bH82X8Ane0fbd05b710f75da1e5c90bc261f2e560d43efa9', $link);
    }

    public function testChangeProductCartQuantity(): void
    {
        $history = [];
        $responses = [
            new Response(204)
        ];

        $client = $this->buildClient($responses, $history);

        $cartProductService = new CartProductService($client);
        $cartProductService->changeProductCartQuantity(
            'carli_2GJ54fACW7H0fYqWs6ZXUnwjN2T',
            'Ieuhp2bj45SXIqgHiAZf5iKSIPN2GJ54lkLb89niWqBtB8bH82X8Ane0fbd05b710f75da1e5c90bc261f2e560d43efa9',
            'd0a7e6eb-8be7-433a-8d64-ffd750b92f49',
            2
        );

        $this->assertCount(1, $history);
        $this->assertSame('POST', $history[0]['request']->getMethod());
        $this->assertSame('/api/v1/checkout/cart-line-items/carli_2GJ54fACW7H0fYqWs6ZXUnwjN2T/component/d0a7e6eb-8be7-433a-8d64-ffd750b92f49/quantity', $history[0]['request']->getUri()->getPath());
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/_requests/change_product_cart_quantity.json', $history[0]['request']->getBody()->getContents());
    }
}
