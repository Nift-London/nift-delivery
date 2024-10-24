<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Query;

use App\Store\Application\Exception\LocationDisabledException;
use App\Store\Application\Exception\LocationNotFoundException;
use App\Store\Application\Exception\StoreValidationException;
use App\Store\Application\Provider\LocationProvider;
use App\Store\Application\Provider\StoreProvider;
use App\Store\Domain\Entity\Location;
use App\Store\Domain\Entity\Store;
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
     * @throws LocationDisabledException
     * @throws LocationNotFoundException
     */
    public function queryByStoreName(
        string $storeName,
        string $street,
        string $postalCode,
        string $city,
    ): Location {
        $store = $this->storeProvider->provideStoreByName($storeName);

        /** @var Location $location */
        foreach ($store->getLocations() as $location) {
            if (
                $street === $location->getStreet() &&
                $postalCode === $location->getPostalCode() &&
                $city === $location->getCity()
            ) {
                if (!$location->isEnabled()) {
                    throw LocationDisabledException::locationDisabledException($location->getId());
                }

                return $location;
            }
        }

        throw LocationNotFoundException::locationNotFoundException($store->getId());
    }

    /**
     * @throws StoreValidationException
     * @throws LocationDisabledException
     * @throws LocationNotFoundException
     */
    public function queryByShopifyDomain(
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
                $city === $location->getCity()
            ) {
                if (!$location->isEnabled()) {
                    throw LocationDisabledException::locationDisabledException($location->getId());
                }

                return $location;
            }
        }

        throw LocationNotFoundException::locationNotFoundException($store->getId());
    }

    /**
     * @throws LocationDisabledException
     * @throws LocationNotFoundException
     */
    public function queryByStore(
        Store $store,
        string $street,
        string $postalCode,
        string $city,
        bool $includeExcluded = false
    ): Location {
        /** @var Location $location */
        foreach ($store->getLocations() as $location) {
            if (
                $street === $location->getStreet() &&
                $postalCode === $location->getPostalCode() &&
                $city === $location->getCity()
            ) {
                if (!$location->isEnabled() && !$includeExcluded) {
                    throw LocationDisabledException::locationDisabledException($location->getId());
                }

                return $location;
            }
        }

        throw LocationNotFoundException::locationNotFoundException($store->getId());
    }

    public function queryEntityById(Uuid $id): Location
    {
        return $this->locationProvider->provideLocationById($id);
    }
}
