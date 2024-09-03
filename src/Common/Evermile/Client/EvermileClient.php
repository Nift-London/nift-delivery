<?php

declare(strict_types=1);

namespace App\Common\Evermile\Client;

use GuzzleHttp\Client;
use OpenAPI\Client\Api\OrdersApi;
use OpenAPI\Client\Api\QuotesApi;
use OpenAPI\Client\ApiException;
use OpenAPI\Client\Configuration;
use OpenAPI\Client\Model\OrderPost201Response;
use OpenAPI\Client\Model\OrderPostRequest;
use OpenAPI\Client\Model\QuotePost200Response;
use OpenAPI\Client\Model\QuotePostRequest;

final class EvermileClient
{
    private string $evermileMerchantId;

    public function __construct(string $host, string $evermileMerchantId, EvermileAuthenticator $evermileAuthenticator)
    {
        $this->evermileMerchantId = $evermileMerchantId;

        $evermileAuthenticator->authorize();
        Configuration::getDefaultConfiguration()->setHost($host);
    }

    public function getQuote(array $requestData): QuotePost200Response
    {
        $apiInstance = new QuotesApi(new Client(), Configuration::getDefaultConfiguration());

        // todo can i limit it for 2 days ahead?
        return $apiInstance->quotePost(new QuotePostRequest($requestData), $this->evermileMerchantId);
    }

    // OrderPost201Response
    public function order(string $id): string
    {
        $apiInstance = new OrdersApi(new Client(), Configuration::getDefaultConfiguration());

        try {
            return $apiInstance->orderPost(new OrderPostRequest([
                'proposal_id' => $id,
                'dropoff_contact_details' => [
                    'contactName' => 'Karol Gasienica' // todo
                ],
            ]), $this->evermileMerchantId)->getId();
        } catch (\Exception $e) {
            return '';
        }
    }
}
