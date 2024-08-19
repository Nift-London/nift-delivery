<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Query;

use App\Quote\Application\Calculator\QuoteCalculator;
use App\Quote\Application\DTO\ProposalQuotesDTO;
use App\Quote\Infrastructure\Evermile\EvermileQuoteProvider;
use App\Quote\Infrastructure\Query\DTO\QuoteQueryDTO;

final class QuoteQuery
{
    private EvermileQuoteProvider $evermileQuoteProvider;
    private QuoteCalculator $quoteCalculator;

    public function __construct(EvermileQuoteProvider $evermileQuoteProvider, QuoteCalculator $quoteCalculator)
    {
        $this->evermileQuoteProvider = $evermileQuoteProvider;
        $this->quoteCalculator = $quoteCalculator;
    }

    public function query(QuoteQueryDTO $query): ProposalQuotesDTO
    {
        // There will be more quote providers in the future. Just merge it in one $quotes array
        $quotes = $this->evermileQuoteProvider->provide($query->getAddressFrom(), $query->getAddressTo(), $query->getStoreDTO());

        return $this->quoteCalculator->calculate($quotes);
    }

}
