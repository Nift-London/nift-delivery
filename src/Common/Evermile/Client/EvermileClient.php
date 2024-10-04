<?php

declare(strict_types=1);

namespace App\Common\Evermile\Client;

use App\Common\Util\EvermileRequestResponseLogger;
use GuzzleHttp\Client;
use OpenAPI\Client\Api\OrdersApi;
use OpenAPI\Client\Api\PickupLocationsApi;
use OpenAPI\Client\Api\QuotesApi;
use OpenAPI\Client\Configuration;
use OpenAPI\Client\Model\LocationPut200Response;
use OpenAPI\Client\Model\LocationPutRequest;
use OpenAPI\Client\Model\OrderPost201Response;
use OpenAPI\Client\Model\OrderPostRequest;
use OpenAPI\Client\Model\QuotePost200Response;
use OpenAPI\Client\Model\QuotePostRequest;

final class EvermileClient
{
    private string $evermileMerchantId;
    private EvermileRequestResponseLogger $logger;

    public function __construct(
        string $host,
        string $evermileMerchantId,
        EvermileAuthenticator $evermileAuthenticator,
        EvermileRequestResponseLogger $logger
    ) {
        $this->evermileMerchantId = $evermileMerchantId;

        $evermileAuthenticator->authorize();
        Configuration::getDefaultConfiguration()->setHost($host);
        $this->logger = $logger;
    }

    public function getQuote(array $requestData): QuotePost200Response
    {
        $apiInstance = new QuotesApi(new Client(), Configuration::getDefaultConfiguration());
        $request = new QuotePostRequest($requestData);
        $response = $apiInstance->quotePost($request, $this->evermileMerchantId);

        $this->logger->log($request, $response);

        return $response;
    }

    public function order(string $id, string $contactName, ?string $contactPhone, ?string $contactEmail): OrderPost201Response
    {
        $apiInstance = new OrdersApi(new Client(), Configuration::getDefaultConfiguration());

        $dropoffContactDetails['contactName'] = $contactName;

        if (!is_null($contactPhone)) {
            $dropoffContactDetails['contactPhone'] = $contactPhone;
        }

        if (!is_null($contactEmail)) {
            $dropoffContactDetails['contactEmail'] = $contactEmail;
        }

        $request = new OrderPostRequest([
            'proposal_id' => $id,
            'dropoff_contact_details' => $dropoffContactDetails,
        ]);

        $response = $apiInstance->orderPost($request, $this->evermileMerchantId);

        $this->logger->log($request, $response);

        return $response;
    }

    public function createLocation(string $name, string $street, string $postalCode, string $city): LocationPut200Response
    {
        $apiInstance = new PickupLocationsApi(new Client(), Configuration::getDefaultConfiguration());

        $request = new LocationPutRequest([
            'location' => [
                'name' => $name,
                'address' => [
                    'addressLine1' => $street,
                    'postalCode' => $postalCode,
                    'city' => $city,
                    'type' => 'store',
                ],
            ]
        ]);

        return $apiInstance->locationPut($request, $this->evermileMerchantId);
    }
}
