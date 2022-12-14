<?php

declare(strict_types=1);

namespace Fynn\Sdk\V1\Checkout;

use Fynn\Sdk\V1\Api\ApiException;
use Fynn\Sdk\V1\Checkout\Request\CreateProductCartRequest;
use Fynn\Sdk\V1\Checkout\Response\CreateCartResponse;
use GuzzleHttp\ClientInterface;

class CartProductService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a new cart with a product and components.
     *
     * @throws ApiException
     */
    public function createProductCart(CreateProductCartRequest $request): CreateCartResponse
    {
        try {
            $response = $this->client->request(
                'POST',
                '/api/v1/checkout/cart-product',
                [
                    'body' => json_encode($request->toArray())
                ]
            );
        } catch (\Exception $e) {
            throw ApiException::fromThrowable($e);
        }

        return new CreateCartResponse(json_decode($response->getBody()->getContents(), true)['data']);
    }

    public function generateCartLink(CreateCartResponse $createCartResponse, string $username, bool $isSandbox = false): string
    {
        $url = $isSandbox ? 'https://%s.sandbox.customerfront.app' : 'https://%s.customerfront.app';

        $url = sprintf($url, $username);

        return sprintf(
            '%s/checkout/cart?c=%s',
            $url,
            $createCartResponse->getCartAuthenticationToken()
        );
    }

    public function changeProductCartQuantity(string $cartLineItemId, string $cartToken, string $productCartComponentId, int $quantity): void
    {
        $this->client->request(
            'POST',
            '/api/v1/checkout/cart-line-items/'. $cartLineItemId .'/component/'. $productCartComponentId .'/quantity',
            [
                'headers' => [
                    'X-Auth-Token' => $cartToken
                ],
                'body' => json_encode([
                    'quantity' => $quantity
                ])
            ]
        );
    }
}
