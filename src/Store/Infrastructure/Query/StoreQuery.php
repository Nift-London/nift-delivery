<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Query;

use App\Store\Application\DTO\StoreDTO;
use App\Store\Application\Exception\StoreValidationException;
use App\Store\Application\Provider\StoreProvider;

final class StoreQuery
{
    private StoreProvider $storeProvider;

    public function __construct(StoreProvider $storeProvider)
    {
        $this->storeProvider = $storeProvider;
    }

    /**
     * @throws StoreValidationException
     */
    public function queryByShopifyDomain(string $shopifyDomain): StoreDTO
    {
        $store = $this->storeProvider->provideStoreByShopifyDomain($shopifyDomain);

        return new StoreDTO($store->getId(),
            $store->getStreet(),
            $store->getPostalCode(),
            $store->getCity(),
            $store->getEvermileLocationId()
        );
    }
}
