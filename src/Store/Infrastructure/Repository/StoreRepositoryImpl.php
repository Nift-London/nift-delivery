<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Repository;

use App\Store\Domain\Entity\Store;
use App\Store\Domain\Repository\StoreRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class StoreRepositoryImpl extends ServiceEntityRepository implements StoreRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Store::class);
    }

    public function save(Store $store): void
    {
        $this->getEntityManager()->persist($store);
        $this->getEntityManager()->flush();
    }

    public function findByShopifyDomain(string $shopifyDomain): ?Store
    {
        return $this->findOneBy(['shopifyDomain' => $shopifyDomain]);
    }
}
