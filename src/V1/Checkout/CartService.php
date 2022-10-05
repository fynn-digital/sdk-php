<?php

namespace Fynn\Sdk\V1\Checkout;

use Fynn\Sdk\V1\Checkout\Response\ConvertCartResponse;
use GuzzleHttp\ClientInterface;

class CartService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function removeCart(string $cartId): void
    {
        $this->client->delete(
            sprintf('/api/v1/carts/%s', $cartId)
        );
    }

    public function convertCart(string $cartId): ConvertCartResponse
    {
        $response = $this->client->request(
            'POST',
            sprintf('/api/v1/carts/%s/convert', $cartId)
        );

        $data = json_decode($response->getBody()->getContents(), true)['data'];

        return new ConvertCartResponse($data);
    }
}
