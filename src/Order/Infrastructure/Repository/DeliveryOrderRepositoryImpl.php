<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Repository;

use App\Order\Domain\Entity\DeliveryOrder;
use App\Order\Domain\Repository\DeliveryOrderRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DeliveryOrderRepositoryImpl extends ServiceEntityRepository implements DeliveryOrderRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryOrder::class);
    }

    public function save(DeliveryOrder $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    public function findByExternalPurchaseId(string $externalPurchaseId): ?DeliveryOrder
    {
        return $this->findOneBy(['externalPurchaseId' => $externalPurchaseId]);
    }
}
