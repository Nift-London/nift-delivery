<?php

declare(strict_types=1);

namespace App\Quote\Domain\Repository;

use App\Quote\Domain\Entity\Quote;

interface QuoteRepository
{
    public function save(Quote $quote): void;
}
