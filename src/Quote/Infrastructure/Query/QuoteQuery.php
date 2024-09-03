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

    public function query(Uuid $id): Quote
    {
        $quote = $this->quoteRepository->findById($id);

        if (is_null($quote)) {
            throw QuoteNotFoundException::storeNotFoundException($id);
        }

        return $this->quoteRepository->findById($id);
    }
}
