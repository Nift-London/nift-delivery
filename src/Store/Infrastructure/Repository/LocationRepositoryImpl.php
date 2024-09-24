<?php

declare(strict_types=1);

namespace App\Store\Infrastructure\Repository;

use App\Store\Domain\Entity\Location;
use App\Store\Domain\Repository\LocationRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class LocationRepositoryImpl extends ServiceEntityRepository implements LocationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function save(Location $location): void
    {
        $this->getEntityManager()->persist($location);
        $this->getEntityManager()->flush();
    }

    public function findByShopifyDomain(string $shopifyDomain): ?Location
    {
        return $this->findOneBy(['shopifyDomain' => $shopifyDomain]);
    }

    public function findById(Uuid $id): ?Location
    {
        return $this->findOneBy(['id' => $id]);
    }
}
