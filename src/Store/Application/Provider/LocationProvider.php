<?php

declare(strict_types=1);

namespace App\Store\Application\Provider;

use App\Store\Application\Exception\StoreValidationException;
use App\Store\Domain\Entity\Location;
use App\Store\Domain\Repository\LocationRepository;
use Symfony\Component\Uid\Uuid;

final class LocationProvider
{
    private LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @throws StoreValidationException
     */
    public function provideLocationByShopifyDomain(string $shopifyDomain): Location
    {
        $store = $this->locationRepository->findByShopifyDomain($shopifyDomain);

//        if (!$this->storeValidator->isStoreValid($store)) {
//            throw StoreValidationException::storeNotFoundException();
//        }

        return $store;
    }

    /**
     * @throws StoreValidationException
     */
    public function provideLocationById(Uuid $id): Location
    {
        $store = $this->locationRepository->findById($id);

        if (is_null($store)) {
            throw StoreValidationException::storeNotFoundException();
        }

        return $store;
    }
}
