<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Query;

use App\Quote\Application\Exception\QuoteNotFoundException;
use App\Quote\Domain\Entity\Quote;
use App\Quote\Domain\Repository\QuoteRepository;
use Symfony\Component\Uid\Uuid;

final class QuoteQuery
{
    private QuoteRepository $quoteRepository;

    public function __construct(QuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @throws QuoteNotFoundException
     * @return Quote[]
     */
    public function query(string $street, string $postalCode, string $city): array
    {
        $quote = $this->quoteRepository->findByStreetPostalCodeCity($street, $postalCode, $city);

        if (empty($quote)) {
            throw QuoteNotFoundException::quoteNotFoundException($street, $postalCode, $city);
        }

        return $quote;
    }
}
