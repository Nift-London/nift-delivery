<?php

declare(strict_types=1);

namespace App\Quote\Domain\Repository;

use App\Quote\Domain\Entity\Quote;
use Symfony\Component\Uid\Uuid;

interface QuoteRepository
{
    public function findByStreetPostalCodeCity(string $street, string $postalCode, string $city): array;
    public function save(Quote $quote): void;
}
