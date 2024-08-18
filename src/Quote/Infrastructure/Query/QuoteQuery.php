<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Query;

use App\Quote\Application\Calculator\QuoteCalculator;
use App\Quote\Domain\DTO\AddressDTO;
use App\Quote\Domain\DTO\ProposalQuotesDTO;
use App\Quote\Domain\DTO\StoreDTO;
use App\Quote\Infrastructure\Evermile\EvermileQuoteProvider;

final class QuoteQuery
{
    private EvermileQuoteProvider $evermileQuoteProvider;
    private QuoteCalculator $quoteCalculator;

    public function __construct(EvermileQuoteProvider $evermileQuoteProvider, QuoteCalculator $quoteCalculator)
    {
        $this->evermileQuoteProvider = $evermileQuoteProvider;
        $this->quoteCalculator = $quoteCalculator;
    }

    public function query(AddressDTO $addressFrom, AddressDTO $addressTo, StoreDTO $storeDTO): ProposalQuotesDTO
    {
        // There will be more quote providers in the future. Just merge it in one $quotes array
        $quotes = $this->evermileQuoteProvider->provide($addressFrom, $addressTo, $storeDTO);

        return $this->quoteCalculator->calculate($quotes);
    }

}
