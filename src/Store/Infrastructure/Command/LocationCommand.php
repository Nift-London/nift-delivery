<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Command;

use App\Common\Evermile\Client\EvermileClient;
use App\Store\Application\Exception\LocationNotFoundException;
use App\Store\Application\Provider\StoreProvider;
use App\Store\Domain\Entity\Location;
use App\Store\Domain\Entity\Store;
use App\Store\Domain\Repository\LocationRepository;
use App\Store\Infrastructure\Query\LocationQuery;
use Psr\Log\LoggerInterface;

final class LocationCommand
{
    private StoreProvider $storeProvider;
    private EvermileClient $evermileClient;
    private LocationRepository $locationRepository;
    private LocationQuery $locationQuery;
    private LoggerInterface $logger;

    public function __construct(
        StoreProvider $storeProvider,
        EvermileClient $evermileClient,
        LocationRepository $locationRepository,
        LocationQuery $locationQuery,
        LoggerInterface $logger
    ) {
        $this->storeProvider = $storeProvider;
        $this->evermileClient = $evermileClient;
        $this->locationRepository = $locationRepository;
        $this->locationQuery = $locationQuery;
        $this->logger = $logger;
    }

    public function createWithStoreName(
        string $storeName,
        string $street,
        string $postalCode,
        string $city,
    ): Location {
        $store = $this->storeProvider->provideStoreByName($storeName);

        $response = $this->evermileClient->createLocation(
            $store->getName() . ' - ' . $street,
            $street,
            $postalCode,
            $city
        );

        $location = (new Location())
            ->setName($street)
            ->setStreet($street)
            ->setPostalCode($postalCode)
            ->setCity($city)
            ->setEvermileLocationId($response->getId())
            ->setStore($store)
            ->setEnabled(true);

        $this->locationRepository->save($location);

        return $location;
    }

    public function createWithShopifyDomain(
        string $shopifyDomain,
        string $street,
        string $postalCode,
        string $city,
    ): Location {
        $store = $this->storeProvider->provideStoreByShopifyDomain($shopifyDomain);

        $response = $this->evermileClient->createLocation(
            $store->getName() . ' - ' . $street,
            $street,
            $postalCode,
            $city
        );

        $location = (new Location())
            ->setName($street)
            ->setStreet($street)
            ->setPostalCode($postalCode)
            ->setCity($city)
            ->setEvermileLocationId($response->getId())
            ->setStore($store)
            ->setEnabled(true);

        $this->locationRepository->save($location);

        return $location;
    }

    public function createForStore(Store $store, array $shopifyData): void
    {
        try {
            $location = $this->locationQuery->queryByStore(
                $store,
                $shopifyData['address1'] . ' ' . $shopifyData['address2'],
                $shopifyData['zip'],
                $shopifyData['city'],
                true
            );
        } catch (LocationNotFoundException $e) {
            $response = $this->evermileClient->createLocation(
                $store->getName() . ' - ' . $shopifyData['name'],
                $shopifyData['address1'] . ' ' . $shopifyData['address2'],
                $shopifyData['zip'],
                $shopifyData['city']
            );

            $location = (new Location())
                ->setName($shopifyData['name'])
                ->setStreet($shopifyData['address1'] . ' ' . $shopifyData['address2'])
                ->setPostalCode($shopifyData['zip'])
                ->setCity($shopifyData['city'])
                ->setEvermileLocationId($response->getId())
                ->setShopifyId((string) $shopifyData['id'])
                ->setStore($store);

            $this->locationRepository->save($location);

            $this->logger->info('Location created.', [
                'store.id' => $store->getId(),
                'location.id' => $location->getId(),
            ]);
        }

        $this->logger->info('Location not created, found existing.', [
            'store.id' => $store->getId(),
            'location.id' => $location->getId(),
        ]);
    }
}
