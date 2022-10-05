<?php

namespace Fynn\Sdk\V1\Debitor;

use Fynn\Sdk\V1\Api\ApiException;
use Fynn\Sdk\V1\Debitor\Request\CreateDebitorAddressRequest;
use Fynn\Sdk\V1\Debitor\Request\CreateDebitorRequest;
use Fynn\Sdk\V1\Debitor\Response\DebitorAddressResponse;
use Fynn\Sdk\V1\Debitor\Response\DebitorResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

class DebitorService
{
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a debitor
     *
     * @param CreateDebitorRequest $request
     *
     * @return string Debitor ID
     * @throws ApiException
     */
    public function createDebitor(CreateDebitorRequest $request): string
    {
        try {
            $response = $this->client->request('POST', '/api/debitors', [
                'body' => $request->toArray()
            ]);
        } catch (ClientException $exception) {
            throw ApiException::fromThrowable($exception);
        }

        return str_replace('/api/debitors/', '', $response->getHeader('Location')[0]);
    }

    public function createDebitorAddress(string $debitorId, CreateDebitorAddressRequest $request): string
    {
        try {
            $response = $this->client->request('POST', sprintf('/api/debitors/%s/addresses', $debitorId), [
                'body' => $request->toArray(),
            ]);
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }

        $addressId = str_replace('/api/debitor-addresses/', '', $response->getHeader('Location')[0]);

        return $addressId;
    }

    public function getDebitor(string $debitorId): ?DebitorResponse
    {
        try {
            $response = $this->client->request('GET', '/api/debitors/' . $debitorId);
        } catch (ClientException $exception) {
            if ($exception->getResponse()->getStatusCode() === 404) {
                return null;
            }

            throw ApiException::fromThrowable($exception);
        }

        return new DebitorResponse(json_decode($response->getBody()->getContents(), true));
    }

    public function getDebitorAddress(string $addressId): ?DebitorAddressResponse
    {
        try {
            $response = $this->client->request('GET', sprintf('/api/debitor-addresses/%s', $addressId));
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                return null;
            }

            throw ApiException::fromThrowable($e);
        }

        return new DebitorAddressResponse(json_decode($response->getBody()->getContents(), true)['data']);
    }
}
