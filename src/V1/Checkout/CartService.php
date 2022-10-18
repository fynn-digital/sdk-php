<?php

namespace Fynn\Sdk\V1\Checkout;

use Fynn\Sdk\V1\Api\ApiException;
use Fynn\Sdk\V1\Checkout\Response\ConvertCartResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class CartService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Deletes a cart.
     *
     * This action can only be performed on an unconverted cart. Otherwise, an error will be thrown.
     *
     * @throws ApiException
     */
    public function removeCart(string $cartId): void
    {
        try {
            $this->client->delete(
                sprintf('/api/v1/checkout/cart/%s', $cartId)
            );
        } catch (GuzzleException $e) {
            throw ApiException::fromThrowable($e);
        }
    }

    /**
     * Converts a cart to a subscription.
     *
     * The cart will be marked as converted and can no longer be modified. The subscription will be created or the payment will be initiated.
     *
     * @throws ApiException
     */
    public function convertCart(string $cartId): ConvertCartResponse
    {
        try {
            $response = $this->client->request(
                'POST',
                sprintf('/api/v1/checkout/cart/%s/order', $cartId),
                [
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                ]
            );
        } catch (GuzzleException $exception) {
            throw ApiException::fromThrowable($exception);
        }

        $data = json_decode($response->getBody()->getContents(), true)['data'];

        return new ConvertCartResponse($data);
    }
}
