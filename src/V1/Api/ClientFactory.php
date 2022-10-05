<?php

namespace Fynn\Sdk\V1\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class ClientFactory
{
    public static function create(
        string $apiKey,
        string $username,
        string $environment = 'sandbox'
    ): ClientInterface {
        if ($environment === 'sandbox') {
            $baseUrl = 'https://' .$username. 'sandbox.coreapi.io';
        } else {
            $baseUrl = 'https://' . $username . 'coreapi.io';
        }

        return new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-API-KEY' => $apiKey,
            ],
        ]);
    }
}
