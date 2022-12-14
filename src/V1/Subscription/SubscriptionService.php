<?php

declare(strict_types=1);

namespace Fynn\Sdk\V1\Subscription;

use Fynn\Sdk\V1\Api\ApiException;
use Fynn\Sdk\V1\Subscription\Request\CancelSubscriptionRequest;
use Fynn\Sdk\V1\Subscription\Request\ChangeSubscriptionComponentQuantityRequest;
use Fynn\Sdk\V1\Subscription\Request\ExtendSubscriptionTrialRequest;
use Fynn\Sdk\V1\Subscription\Response\SubscriptionProductResponse;
use Fynn\Sdk\V1\Subscription\Response\SubscriptionResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

class SubscriptionService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Cancel subscription
     *
     * All products and components will be cancelled on the given end date. If the end date is not applicable,
     * the products and components will be cancelled on the next valid cancellation date.
     *
     * Product components will be cancelled on the cancellation date of their product.
     *
     * @throws ApiException
     */
    public function cancelSubscription(string $subscriptionId, CancelSubscriptionRequest $request): void
    {
        try {
            $this->client->request(
                'POST',
                sprintf('/api/subscriptions/%s/cancel', $subscriptionId),
                [
                    'body' => json_encode($request->toArray())
                ]
            );
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }
    }

    /**
     * Get subscription
     *
     * @throws ApiException
     */
    public function getSubscription(string $subscriptionId): ?SubscriptionResponse
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('/api/subscriptions/%s', $subscriptionId)
            );

            $data = json_decode($response->getBody()->getContents(), true)['data'];
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                return null;
            }

            throw ApiException::fromThrowable($e);
        }

        return new SubscriptionResponse($data);
    }

    /**
     * Pauses the subscription until it is resumed. During the pause period, no products or components will be billed.
     *
     * @throws ApiException
     */
    public function pauseSubscription(string $subscriptionId): void
    {
        try {
            $this->client->request(
                'POST',
                sprintf('/api/subscriptions/%s/pause', $subscriptionId)
            );
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }
    }

    /**
     * Resumes the subscription after it has been paused.
     *
     * @throws ApiException
     */
    public function resumeSubscription(string $subscriptionId): void
    {
        try {
            $this->client->request(
                'POST',
                sprintf('/api/subscriptions/%s/activate', $subscriptionId)
            );
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }
    }

    /**
     * Changes the quantity of components with type "quantity". Product components with type "metered" requires to push usage data.
     *
     * @throws ApiException
     */
    public function changeSubscriptionComponentQuantity(string $subscriptionComponentId, ChangeSubscriptionComponentQuantityRequest $request): void
    {
        try {
            $this->client->request(
                'PUT',
                sprintf('/api/subscription-product-components/%s/quantity', $subscriptionComponentId),
                [
                    'body' => json_encode($request->toArray())
                ]
            );
        } catch (ClientException $exception) {
            throw ApiException::fromThrowable($exception);
        }
    }

    /**
     * @param string $subscriptionId
     *
     * @return SubscriptionProductResponse[]
     *
     * @throws ApiException
     */
    public function getSubscriptionProducts(string $subscriptionId): array
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('/api/subscriptions/%s/products', $subscriptionId)
            );

            $data = json_decode($response->getBody()->getContents(), true)['data'];
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                return [];
            }

            throw ApiException::fromThrowable($e);
        }

        return array_map(fn (array $item) => new SubscriptionProductResponse($item), $data);
    }

    /**
     * Extends the trial period of a subscription. A trial can only be extended if the subscription is in trial.
     *
     * @throws ApiException
     */
    public function extendTrial(string $subscriptionId, ExtendSubscriptionTrialRequest $request): void
    {
        try {
            $this->client->request(
                'POST',
                sprintf('/api/subscriptions/%s/trial/extend', $subscriptionId),
                [
                    'body' => json_encode($request->toArray())
                ]
            );
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }
    }

    /**
     * Cancels the trial period of a subscription. A trial can only be cancelled if the subscription is in trial.
     * The subscription will be canceled immediately. No invoices will be created.
     */
    public function cancelTrial(string $subscriptionId): void
    {
        try {
            $this->client->request(
                'POST',
                sprintf('/api/subscriptions/%s/trial/cancel', $subscriptionId)
            );
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }
    }

    /**
     * Activates the subscription. The subscription will be billed from the next billing date.
     *
     * If a trial period is specified, the subscription will start a trial-phase and will be activated on the trial end date.
     * During that period, no invoices will be created.
     *
     * @param string $subscriptionId
     * @param string|null $trialPeriod
     *
     * @throws ApiException
     */
    public function activateSubscription(string $subscriptionId, ?string $trialPeriod = null): void
    {
        try {
            $this->client->request(
                'POST',
                sprintf('/api/subscriptions/%s/activate', $subscriptionId),
                [
                    'body' => json_encode([
                        'trialPeriod' => $trialPeriod
                    ])
                ]
            );
        } catch (ClientException $e) {
            throw ApiException::fromThrowable($e);
        }
    }
}
