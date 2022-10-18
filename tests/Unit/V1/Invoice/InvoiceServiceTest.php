<?php

namespace Fynn\Sdk\Unit\V1\Invoice;

use Fynn\Sdk\Tests\AbstractUnitTest;
use Fynn\Sdk\V1\Invoice\InvoiceService;
use GuzzleHttp\Psr7\Response;

/**
 * @covers \Fynn\Sdk\V1\Invoice\InvoiceService
 */
class InvoiceServiceTest extends AbstractUnitTest
{
    public function testGetInvoice(): void
    {
        $history = [];
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/get_invoice.json'),
        ];

        $client = $this->buildClient($responses, $history);

        $service = new InvoiceService($client);

        $response = $service->getInvoice('c8a510fd-5b22-4bc1-9056-c6b263bb3198');

        $this->assertSame('c8a510fd-5b22-4bc1-9056-c6b263bb3198', $response->getId());
        $this->assertSame('STATUS_PAID', $response->getStatus());
        $this->assertSame('RE0000000000010034', $response->getInvoiceNumber());
        $this->assertSame('2352757b-65c7-4b0a-9fa2-c64883315ae5', $response->getDebitorId());
        $this->assertSame('c805ed02-bb24-4621-ae03-8944844fdb9b', $response->getReceiverAddressId());
        $this->assertSame('2022-09-20 13:10:41', $response->getDueDate()->format('Y-m-d H:i:s'));
        $this->assertSame('TYPE_INVOICE', $response->getInvoiceType());
        $this->assertSame('/invoices/c8a510fd-5b22-4bc1-9056-c6b263bb3198/download', $response->getPdfUrl());
        $this->assertNull($response->getNotice());
        $this->assertSame('637d211a-ac00-40a6-a542-1d85369433c9', $response->getPaymentMethodId());
        $this->assertSame('2022-09-06 13:10:44', $response->getFinalizationDate()->format('Y-m-d H:i:s'));
        $this->assertSame('EUR', $response->getCurrencyCode());

        $this->assertSame(4900.0, $response->getNetAmount()->getCentAmount());
        $this->assertSame(5831.0, $response->getGrossAmount()->getCentAmount());
        $this->assertSame(931.0, $response->getTaxAmount()->getCentAmount());

        $this->assertSame('/api/invoices/c8a510fd-5b22-4bc1-9056-c6b263bb3198', $history[0]['request']->getUri()->getPath());
        $this->assertSame('GET', $history[0]['request']->getMethod());
    }

    public function testGetDebitorInvoices(): void
    {
        $history = [];
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/get_invoices.json'),
        ];

        $client = $this->buildClient($responses, $history);

        $service = new InvoiceService($client);

        $response = $service->getDebitorInvoices('2352757b-65c7-4b0a-9fa2-c64883315ae5');

        $this->assertCount(6, $response);
        $this->assertSame('debitorId=2352757b-65c7-4b0a-9fa2-c64883315ae5&_page=1&limit=25', $history[0]['request']->getUri()->getQuery());
        $this->assertSame('/api/invoices', $history[0]['request']->getUri()->getPath());
        $this->assertSame('GET', $history[0]['request']->getMethod());
    }

    public function testGetInvoices(): void
    {
        $history = [];
        $responses = [
            $this->buildJsonResponse(200, __DIR__ . '/_responses/get_invoices.json'),
        ];

        $client = $this->buildClient($responses, $history);

        $service = new InvoiceService($client);

        $response = $service->getInvoices();

        $this->assertCount(6, $response);
        $this->assertSame('_page=1&limit=25', $history[0]['request']->getUri()->getQuery());
        $this->assertSame('/api/invoices', $history[0]['request']->getUri()->getPath());
        $this->assertSame('GET', $history[0]['request']->getMethod());
    }

    public function testDownloadInvoice(): void
    {
        $history = [];
        $responses = [
            new Response(200, ['Content-Type' => 'application/pdf'], 'some pdf stream'),
        ];

        $client = $this->buildClient($responses, $history);

        $service = new InvoiceService($client);

        $response = $service->downloadInvoice('c8a510fd-5b22-4bc1-9056-c6b263bb3198');

        $this->assertSame('some pdf stream', $response);
        $this->assertSame('/invoices/c8a510fd-5b22-4bc1-9056-c6b263bb3198/download', $history[0]['request']->getUri()->getPath());
        $this->assertSame('GET', $history[0]['request']->getMethod());
    }
}
