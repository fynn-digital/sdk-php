<?php

namespace Fynn\Sdk\Tests\Unit\V1\Api;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Api\ClientFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

/**
 * @covers \Fynn\Sdk\V1\Api\ClientFactory
 */
class ClientFactoryTest extends AbstractUnitTest
{
    public function testCreatesInstanceOfGuzzleClient(): void
    {
        $client = ClientFactory::create('apiKey', 'username', 'sandbox');

        $this->assertInstanceOf(ClientInterface::class, $client);
    }

    public function testClientHasApiKeyHeader(): void
    {
        $container = [];
        $responses = [
            new Response(200, [], ''),
        ];

        $client = $this->buildClient(
            $responses,
            $container,
            'apiKey',
            'username',
            'sandbox'
        );

        $client->request('GET', '/');

        $this->assertArrayHasKey('X-API-KEY', $container[0]['request']->getHeaders());
        $this->assertSame('apiKey', $container[0]['request']->getHeaderLine('X-API-KEY'));
    }

    public function testClientHasContentTypeHeader(): void
    {
        $container = [];
        $responses = [
            new Response(200, [], ''),
        ];

        $client = $this->buildClient(
            $responses,
            $container,
            'apiKey',
            'username',
            'sandbox'
        );

        $client->request('GET', '/');

        $this->assertArrayHasKey('Content-Type', $container[0]['request']->getHeaders());
        $this->assertSame('application/json', $container[0]['request']->getHeaderLine('Content-Type'));
    }

    public function testClientHasAcceptHeader(): void
    {
        $container = [];
        $responses = [
            new Response(200, [], ''),
        ];

        $client = $this->buildClient(
            $responses,
            $container,
            'apiKey',
            'username',
            'sandbox'
        );

        $client->request('GET', '/');

        $this->assertArrayHasKey('Accept', $container[0]['request']->getHeaders());
        $this->assertSame('application/json', $container[0]['request']->getHeaderLine('Accept'));
    }

    public function testClientHasCorrectBaseUrl(): void
    {
        $container = [];
        $responses = [
            new Response(200, [], ''),
        ];

        $client = $this->buildClient(
            $responses,
            $container,
            'apiKey',
            'username',
            'sandbox'
        );

        $client->request('GET', '/');

        $this->assertSame('https://username.sandbox.coreapi.io/', (string) $container[0]['request']->getUri());
    }

    public function testClientHasCorrectBaseUrlForProduction(): void
    {
        $container = [];
        $responses = [
            new Response(200, [], ''),
        ];

        $client = $this->buildClient(
            $responses,
            $container,
            'apiKey',
            'username',
            'production'
        );

        $client->request('GET', '/');

        $this->assertSame('https://username.coreapi.io/', (string) $container[0]['request']->getUri());
    }
}
