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

    public function findByStreetPostalCodeCity(string $street, string $postalCode, string $city): array
    {
        // todo set max to 10 mins

        return $this->findBy([
            'delivery_street' => $street,
            'delivery_postal_code' => $postalCode,
            'delivery_city' => $city
        ]);
    }
}
