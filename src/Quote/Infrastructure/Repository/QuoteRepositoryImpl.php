<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Repository;

use App\Quote\Domain\Entity\Quote;
use App\Quote\Domain\Repository\QuoteRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class QuoteRepositoryImpl extends ServiceEntityRepository implements QuoteRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function save(Quote $quote): void
    {
        $this->getEntityManager()->persist($quote);
        $this->getEntityManager()->flush();
    }

    public function findById(Uuid $id): ?Quote
    {
        return $this->findOneBy(['id' => $id]);
    }
}
