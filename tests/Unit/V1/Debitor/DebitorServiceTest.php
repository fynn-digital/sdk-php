<?php

namespace Fynn\Sdk\Tests\Unit\V1\Debitor;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Debitor\DebitorService;
use Fynn\Sdk\V1\Debitor\Request\CreateDebitorAddressRequest;
use Fynn\Sdk\V1\Debitor\Request\CreateDebitorRequest;
use Fynn\Sdk\V1\Debitor\Response\DebitorAddressResponse;
use Fynn\Sdk\V1\Debitor\Response\DebitorResponse;
use GuzzleHttp\Psr7\Response;

/**
 * @covers \Fynn\Sdk\V1\Debitor\DebitorService
 */
class DebitorServiceTest extends AbstractUnitTest
{
    public function testGetDebitor(): void
    {
        $history = [];
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/get_debitor.json'),
        ];

        $client = $this->buildClient($responses, $history);

        $debitorService = new DebitorService($client);
        $debitor = $debitorService->getDebitor('f1d7d286-b88b-4849-9cb3-e30dc22f9747');

        $this->assertInstanceOf(DebitorResponse::class, $debitor);
    }

    public function testGetDebitorIsNotFoundReturnsNullInsteadOfGuzzleException(): void
    {
        $history = [];
        $responses = [
            new Response(404),
        ];

        $client = $this->buildClient($responses, $history);

        $debitorService = new DebitorService($client);
        $debitor = $debitorService->getDebitor('f1d7d286-b88b-4849-9cb3-e30dc22f9747');

        $this->assertNull($debitor);
    }

    public function testGetDebitorAddress(): void
    {
        $history = [];
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/get_debitor_address.json'),
        ];

        $client = $this->buildClient($responses, $history);

        $debitorService = new DebitorService($client);
        $debitorAddress = $debitorService->getDebitorAddress('f1d7d286-b88b-4849-9cb3-e30dc22f9747');

        $this->assertInstanceOf(DebitorAddressResponse::class, $debitorAddress);
    }

    public function testGetDebitorAddressIsNotFoundReturnsNullInsteadOfGuzzleException(): void
    {
        $history = [];
        $responses = [
            new Response(404)
        ];

        $client = $this->buildClient($responses, $history);

        $debitorService = new DebitorService($client);
        $debitorAddress = $debitorService->getDebitorAddress('f1d7d286-b88b-4849-9cb3-e30dc22f9747');

        $this->assertNull($debitorAddress);
    }

    public function testGetDebitorAddresses(): void
    {
        $history = [];
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/get_debitor_addresses.json'),
        ];

        $client = $this->buildClient($responses, $history);

        $debitorService = new DebitorService($client);
        $debitorAddresses = $debitorService->getDebitorAddresses('f1d7d286-b88b-4849-9cb3-e30dc22f9747');

        $this->assertContainsOnlyInstancesOf(DebitorAddressResponse::class, $debitorAddresses);
        $this->assertIsArray($debitorAddresses);
        $this->assertCount(2, $debitorAddresses);
    }

    public function testGetDebitorAddressesIsNotFoundReturnsEmptyArrayInsteadOfGuzzleException(): void
    {
        $history = [];
        $responses = [
            new Response(404)
        ];

        $client = $this->buildClient($responses, $history);

        $debitorService = new DebitorService($client);
        $debitorAddresses = $debitorService->getDebitorAddresses('f1d7d286-b88b-4849-9cb3-e30dc22f9747');

        $this->assertSame([], $debitorAddresses);
    }

    public function testCreateDebitorSendsRequestWithAllRequiredFields(): void
    {
        $history = [];
        $responses = [
            new Response(201, ['Location' => '/api/debitors/f1d7d286-b88b-4849-9cb3-e30dc22f9747']),
        ];

        $client = $this->buildClient($responses, $history);

        $debitorService = new DebitorService($client);
        $debitorId = $debitorService->createDebitor(new CreateDebitorRequest(
            'hi@fynn.eu',
            'Max',
            'Mustermann',
            'Some Company',
            'DE1239234',
            '+4912372348234',
            'Amtsgericht Köln',
            'HRB 123456',
            '10000',
            'DE',
            'de',
            'EUR'
        ));

        $this->assertCount(1, $history);
        $this->assertSame('POST', $history[0]['request']->getMethod());
        $this->assertSame('https://username.sandbox.coreapi.io/api/debitors', (string) $history[0]['request']->getUri());
        $this->assertSame('application/json', $history[0]['request']->getHeaderLine('Content-Type'));
        $this->assertSame('application/json', $history[0]['request']->getHeaderLine('Accept'));
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/_requests/create_debitor.json', $history[0]['request']->getBody()->getContents());

        $this->assertSame($debitorId, 'f1d7d286-b88b-4849-9cb3-e30dc22f9747');
    }

    public function testCreateDebitorAddressSendsRequestWithAllRequiredFields(): void
    {
        $history = [];
        $responses = [
            new Response(201, ['Location' => '/api/debitor-addresses/be7450b7-e8ea-4ed3-bb5b-6d838a3bd932']),
        ];

        $client = $this->buildClient($responses, $history);

        $request = new CreateDebitorAddressRequest(
            'Herr',
            'Max',
            'Mustermann',
            'Some Company',
            'Some Street',
            '1',
            '12345',
            'Some City',
            'DE',
            'TYPE_INVOICE',
            true
        );

        $debitorService = new DebitorService($client);
        $debitorAddressId = $debitorService->createDebitorAddress('f1d7d286-b88b-4849-9cb3-e30dc22f9747', $request);

        $this->assertCount(1, $history);
        $this->assertSame('POST', $history[0]['request']->getMethod());
        $this->assertSame('https://username.sandbox.coreapi.io/api/debitors/f1d7d286-b88b-4849-9cb3-e30dc22f9747/addresses', (string) $history[0]['request']->getUri());
        $this->assertSame('application/json', $history[0]['request']->getHeaderLine('Content-Type'));
        $this->assertSame('application/json', $history[0]['request']->getHeaderLine('Accept'));
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/_requests/create_debitor_address.json', $history[0]['request']->getBody()->getContents());

        $this->assertSame($debitorAddressId, 'be7450b7-e8ea-4ed3-bb5b-6d838a3bd932');
    }


}
