<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Query;

use App\Quote\Application\Calculator\QuoteCalculator;
use App\Quote\Application\DTO\ProposalQuotesDTO;
use App\Quote\Application\Saver\QuoteSaver;
use App\Quote\Infrastructure\Evermile\EvermileQuoteProvider;
use App\Quote\Infrastructure\Query\DTO\QuoteQueryDTO;

final class ProposalQuoteQuery
{
    private EvermileQuoteProvider $evermileQuoteProvider;
    private QuoteCalculator $quoteCalculator;
    private QuoteSaver $quoteSaver;

    public function __construct(
        EvermileQuoteProvider $evermileQuoteProvider,
        QuoteCalculator $quoteCalculator,
        QuoteSaver $quoteSaver
    ) {
        $this->evermileQuoteProvider = $evermileQuoteProvider;
        $this->quoteCalculator = $quoteCalculator;
        $this->quoteSaver = $quoteSaver;
    }

    public function query(QuoteQueryDTO $query): ProposalQuotesDTO
    {
        // There will be more quote providers in the future. Just merge it in one $quotes array
        $quotes = $this->evermileQuoteProvider->provide($query->getAddressFrom(), $query->getAddressTo(), $query->getStoreDTO());
        $calculatedQuotes = $this->quoteCalculator->calculate($quotes);
        $this->quoteSaver->save($calculatedQuotes, $query->getStoreId(), $query->getAddressTo());

        return $calculatedQuotes;
    }

}
