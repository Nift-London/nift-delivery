<?php

declare(strict_types=1);

namespace App\Store\Domain\Repository;

use App\Store\Domain\Entity\Store;
use Symfony\Component\Uid\Uuid;

interface StoreRepository
{
    public function save(Store $store): void;
    public function findByShopifyDomain(string $shopifyDomain): ?Store;
    public function findByName(string $name): ?Store;
    public function findById(Uuid $id);
}
