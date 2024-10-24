<?php

declare(strict_types=1);

namespace App\Store\Application\Provider;

use App\Store\Application\Exception\StoreValidationException;
use App\Store\Domain\Entity\Location;
use App\Store\Domain\Entity\Store;
use App\Store\Domain\Repository\LocationRepository;
use App\Store\Domain\Repository\StoreRepository;
use Symfony\Component\Uid\Uuid;

final class StoreProvider
{
    private StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * @throws StoreValidationException
     */
    public function provideStoreByShopifyDomain(string $shopifyDomain): Store
    {
        $store = $this->storeRepository->findByShopifyDomain($shopifyDomain);

        if (is_null($store) || !$store->isEnabled()) {
            throw StoreValidationException::storeNotFoundException();
        }

        return $store;
    }

    /**
     * @throws StoreValidationException
     */
    public function provideStoreByName(string $name): Store
    {
        $store = $this->storeRepository->findByName($name);

        if (is_null($store) || !$store->isEnabled()) {
            throw StoreValidationException::storeNotFoundException();
        }

        return $store;
    }
}
