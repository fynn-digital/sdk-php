<?php

namespace Fynn\Sdk\Tests;

use Fynn\Sdk\V1\Api\ClientFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

abstract class AbstractUnitTest extends TestCase
{
    protected function buildClient(
        array $responses = [],
        array &$history = [],
        string $apiKey = 'apiKey',
        string $username = 'username',
        string $environment = 'sandbox'
    ): ClientInterface {
        $mockHandler = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mockHandler);

        $historyMiddleware = Middleware::history($history);
        $handlerStack->push($historyMiddleware);

        return ClientFactory::create(
            $apiKey,
            $username,
            $environment,
            $handlerStack
        );
    }

    protected function buildJsonResponse(int $statusCode, string $fileName): Response
    {
        return new Response(
            $statusCode,
            [
                'Content-Type' => 'application/json',
            ],
            file_get_contents($fileName)
        );
    }
}
