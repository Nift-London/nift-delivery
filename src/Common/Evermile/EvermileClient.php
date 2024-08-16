<?php

declare(strict_types=1);

namespace App\Common\Evermile;

use GuzzleHttp\Client;
use OpenAPI\Client\Api\PickupLocationsApi;
use OpenAPI\Client\Configuration;

final class EvermileClient
{
    private string $evermileMerchantId;

    public function __construct(string $host, string $evermileMerchantId, EvermileAuthenticator $evermileAuthenticator)
    {
        $this->evermileMerchantId = $evermileMerchantId;

        $evermileAuthenticator->authorize();
        Configuration::getDefaultConfiguration()->setHost($host);
    }

    public function getPickupLocationsClient()
    {
        $apiInstance = new PickupLocationsApi(new Client(), Configuration::getDefaultConfiguration());

        dd($apiInstance->locationsGet($this->evermileMerchantId));
    }
}
