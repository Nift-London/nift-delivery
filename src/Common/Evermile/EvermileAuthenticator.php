<?php

declare(strict_types=1);

namespace App\Common\Evermile;

use GuzzleHttp\Client;
use OpenAPI\Client\Configuration;

final class EvermileAuthenticator
{
    private string $evermileAuthHost;
    private string $evermileClientId;
    private string $evermileClientSecret;

    public function __construct(string $evermileAuthHost, string $evermileClientId, string $evermileClientSecret)
    {
        $this->evermileAuthHost = $evermileAuthHost;
        $this->evermileClientId = $evermileClientId;
        $this->evermileClientSecret = $evermileClientSecret;
    }

    public function authorize(): void
    {
        $response = (new Client())->post($this->evermileAuthHost, [
            'auth' => [$this->evermileClientId, $this->evermileClientSecret],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);

        $accessToken = json_decode($response->getBody()->getContents(), true)['access_token'];

        Configuration::getDefaultConfiguration()->setAccessToken($accessToken);
    }
}
