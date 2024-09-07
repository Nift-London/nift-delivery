<?php

declare(strict_types=1);

namespace App\Store\Domain\Repository;

use App\Store\Domain\Entity\Store;

interface StoreRepository
{
    public function save(Store $store): void;
    public function findByShopifyDomain(string $shopifyDomain): ?Store;
}
