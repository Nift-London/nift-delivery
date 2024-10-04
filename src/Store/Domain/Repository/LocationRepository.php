<?php

declare(strict_types=1);

namespace App\Store\Domain\Repository;

use App\Store\Domain\Entity\Location;
use Symfony\Component\Uid\Uuid;

interface LocationRepository
{
    public function save(Location $location): void;
    public function findByShopifyDomain(string $shopifyDomain): ?Location;
    public function findById(Uuid $id): ?Location;
}
