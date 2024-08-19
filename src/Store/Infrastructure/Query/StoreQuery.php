<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Query;

use App\Store\Application\DTO\StoreDTO;
use App\Store\Application\Provider\StoreProvider;

final class StoreQuery
{
    private StoreProvider $storeProvider;

    public function __construct(StoreProvider $storeProvider)
    {
        $this->storeProvider = $storeProvider;
    }

    public function queryByShopifyName(string $shopifyName): StoreDTO
    {
        $store = $this->storeProvider->provideStoreByShopifyName();
        return new StoreDTO(1, 'Street', 'asd', 'London', $store->getExternalData()->getEvermileLocationId());
    }
}
