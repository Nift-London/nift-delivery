<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Query;

use App\Store\Application\Exception\StoreValidationException;
use App\Store\Application\Provider\LocationProvider;
use App\Store\Application\Provider\StoreProvider;
use App\Store\Domain\Entity\Location;
use Symfony\Component\Uid\Uuid;

final class LocationQuery
{
    private LocationProvider $locationProvider;
    private StoreProvider $storeProvider;

    public function __construct(LocationProvider $locationProvider, StoreProvider $storeProvider)
    {
        $this->locationProvider = $locationProvider;
        $this->storeProvider = $storeProvider;
    }

    /**
     * @throws StoreValidationException
     */
    public function query(
        string $shopifyDomain,
        string $street,
        string $postalCode,
        string $city,
    ): Location {
        $store = $this->storeProvider->provideStoreByShopifyDomain($shopifyDomain);

        /** @var Location $location */
        foreach ($store->getLocations() as $location) {
            if (
                $street === $location->getStreet() &&
                $postalCode === $location->getPostalCode() &&
                $city === $location->getCity()) {
                return $location;
            }
        }

        // todo create location in evermail
        throw new \Exception('Location not found');
    }

    public function queryEntityById(Uuid $id): Location
    {
        return $this->locationProvider->provideLocationById($id);
    }
}
