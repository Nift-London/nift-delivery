<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Command;

use App\Store\Domain\Entity\Store;
use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;

final class SyncLocationsCommand
{
    private LocationCommand $locationCommand;
    private LoggerInterface $logger;

    public function __construct(LocationCommand $locationCommand, LoggerInterface $logger)
    {
        $this->locationCommand = $locationCommand;
        $this->logger = $logger;
    }

    public function sync(Store $store): void
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request('GET', 'https://' . $store->getShopifyDomain() . '/admin/api/2024-04/locations.json', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Shopify-Access-Token' => $store->getShopifyToken()
                ]
            ]);

        } catch (ClientException $e) {
            $this->logger->error('Failed to fetch locations from Shopify', [
                'store.id' => $store->getId(),
                'store.name' => $store->getName(),
                'error' => $e->getMessage()
            ]);

            return;
        }

        $locations = json_decode($response->getBody()->getContents(), true)['locations'];

        foreach ($locations as $location) {
            if (
                !$location['active']
                || $location['country'] !== 'GB'
                || empty($location['address1'])
                || empty($location['zip'])
                || empty($location['city'])
            ) {
                continue;
            }

            $this->locationCommand->createForStore($store, $location);
        }
    }
}
