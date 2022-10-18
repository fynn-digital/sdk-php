<?php

namespace Fynn\Sdk\V1\Debitor;

use Fynn\Sdk\V1\Api\ApiException;
use Fynn\Sdk\V1\Debitor\Response\DebitorCreditBalanceResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

class DebitorCreditBalanceService
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getCreditBalance(string $debitorId): DebitorCreditBalanceResponse
    {
        try {
            $response = $this->client->get(sprintf('/api/debitors/%s/creditBalance', $debitorId));
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }

        $data = json_decode($response->getBody()->getContents(), true)['data'];

        return new DebitorCreditBalanceResponse($data);
    }

    public function bookCreditBalance(string $debitorId, int $amountInCents, ?string $description = null, ?string $referenceId = null): void
    {
        try {
            $response = $this->client->request('POST', sprintf('/api/debitors/%s/creditBalance', $debitorId), [
                'body' => json_encode([
                    'amount' => $amountInCents,
                    'description' => $description,
                    'referenceId' => $referenceId,
                    'expirationDate' => null,
                ]),
            ]);
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }
    }
}
