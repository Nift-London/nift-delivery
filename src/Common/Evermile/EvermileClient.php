<?php

declare(strict_types=1);

namespace App\Common\Evermile;

use GuzzleHttp\Client;
use OpenAPI\Client\Api\QuotesApi;
use OpenAPI\Client\Configuration;
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

        // todo can i limit it for 2 days?
        return $apiInstance->quotePost(new QuotePostRequest($requestData), $this->evermileMerchantId);
    }
}
