<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Command;

use App\Common\Evermile\Client\EvermileClient;
use App\Store\Application\Provider\StoreProvider;
use App\Store\Domain\Entity\Location;
use App\Store\Domain\Repository\LocationRepository;

final class LocationCommand
{
    private StoreProvider $storeProvider;
    private EvermileClient $evermileClient;
    private LocationRepository $locationRepository;

    public function __construct(
        StoreProvider $storeProvider,
        EvermileClient $evermileClient,
        LocationRepository $locationRepository
    ) {
        $this->storeProvider = $storeProvider;
        $this->evermileClient = $evermileClient;
        $this->locationRepository = $locationRepository;
    }

    public function create(
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
}
