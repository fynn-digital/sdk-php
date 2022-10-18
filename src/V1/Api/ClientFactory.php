<?php

namespace Fynn\Sdk\V1\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;

class ClientFactory
{
    public static function create(
        string $apiKey,
        string $username,
        string $environment = 'sandbox',
        ?HandlerStack $handlerStack = null
    ): ClientInterface {
        if ($environment === 'sandbox') {
            $baseUrl = 'https://' .$username. '.sandbox.coreapi.io';
        } else {
            $baseUrl = 'https://' . $username . '.coreapi.io';
        }

        $config = [
            'base_uri' => $baseUrl,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-API-KEY' => $apiKey,
            ],
        ];

        if ($handlerStack instanceof HandlerStack) {
            $config['handler'] = $handlerStack;
        }

        return new Client($config);
    }
}
