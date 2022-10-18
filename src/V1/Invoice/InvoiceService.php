<?php

namespace Fynn\Sdk\V1\Invoice;

use Fynn\Sdk\V1\Api\ApiException;
use Fynn\Sdk\V1\Invoice\Response\InvoiceResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

class InvoiceService
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getInvoice(string $invoiceId): ?InvoiceResponse
    {
        try {
            $response = $this->client->request('GET', '/api/invoices/' . $invoiceId);
        } catch (ClientException $exception) {
            if ($exception->getResponse()->getStatusCode() === 404) {
                return null;
            }

            throw ApiException::fromThrowable($exception);
        }

        return new InvoiceResponse(json_decode($response->getBody()->getContents(), true)['data']);
    }

    public function downloadInvoice(string $invoiceId): ?string
    {
        try {
            $response = $this->client->request('GET', '/invoices/' . $invoiceId . '/download');
        } catch (ClientException $exception) {
            if ($exception->getResponse()->getStatusCode() === 404) {
                return null;
            }

            throw ApiException::fromThrowable($exception);
        }

        return $response->getBody()->getContents();
    }

    /**
     * @return InvoiceResponse[]
     */
    public function getDebitorInvoices(string $debitorId, int $page = 1, int $limit = 25): array
    {
        try {
            $response = $this->client->request('GET', '/api/invoices?debitorId=' . $debitorId . '&_page='.$page.'&limit='.$limit);
        } catch (ClientException $exception) {
            throw ApiException::fromThrowable($exception);
        }

        $invoices = [];
        foreach (json_decode($response->getBody()->getContents(), true)['data'] as $invoice) {
            $invoices[] = new InvoiceResponse($invoice);
        }

        return $invoices;
    }

    /**
     * @return InvoiceResponse[]
     */
    public function getInvoices(int $page = 1, int $limit = 25): array
    {
        try {
            $response = $this->client->request('GET', '/api/invoices?_page='.$page.'&limit='.$limit);
        } catch (ClientException $exception) {
            throw ApiException::fromThrowable($exception);
        }

        $invoices = [];
        foreach (json_decode($response->getBody()->getContents(), true)['data'] as $invoice) {
            $invoices[] = new InvoiceResponse($invoice);
        }

        return $invoices;
    }
}
