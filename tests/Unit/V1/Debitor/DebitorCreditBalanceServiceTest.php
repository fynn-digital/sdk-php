<?php

namespace Fynn\Sdk\Tests\Unit\V1\Debitor;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Debitor\DebitorCreditBalanceService;
use GuzzleHttp\Psr7\Response;

class DebitorCreditBalanceServiceTest extends AbstractUnitTest
{
    public function testGetCreditBalance(): void
    {
        $history = [];
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/get_debitor_credit_balance.json'),
        ];

        $client = $this->buildClient($responses, $history);

        $service = new DebitorCreditBalanceService($client);

        $response = $service->getCreditBalance('f1d7d286-b88b-4849-9cb3-e30dc22f9747');

        $this->assertSame(2, $response->getPrecision());
        $this->assertSame(100, $response->getAmount());
        $this->assertSame('EUR', $response->getCurrencyCode());
    }

    public function testBookCreditBalance(): void
    {
        $history = [];
        $responses = [
            new Response(204),
        ];

        $client = $this->buildClient($responses, $history);

        $service = new DebitorCreditBalanceService($client);

        $service->bookCreditBalance('f1d7d286-b88b-4849-9cb3-e30dc22f9747', 100, 'Test', '1234');

        $this->assertCount(1, $history);
        $this->assertSame('POST', $history[0]['request']->getMethod());
        $this->assertSame('/api/debitors/f1d7d286-b88b-4849-9cb3-e30dc22f9747/creditBalance', $history[0]['request']->getUri()->getPath());

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/_requests/book_debitor_credit_balance.json', $history[0]['request']->getBody()->getContents());
    }
}
