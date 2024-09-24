<?php

declare(strict_types=1);

namespace App\Quote\Application\Calculator;

use App\Quote\Application\DTO\ProposalQuotesDTO;
use App\Quote\Application\DTO\QuoteDTO;

// This will be strategy in future to calculate cheapest/fastest quotes
final class QuoteCalculator
{
    /** @param QuoteDTO[] $quotes */
    public function calculate(array $quotes): ProposalQuotesDTO
    {
        if (empty($quotes)) {
            return ProposalQuotesDTO::ofNoAvailableRates();
        }

        $this->sortQuotes($quotes);

        return new ProposalQuotesDTO($this->getTodayFastest($quotes), $this->getTodayEvening($quotes), $this->getLatest($quotes));
    }

    private function sortQuotes(array &$quotes): void
    {
        usort($quotes, function (QuoteDTO $a, QuoteDTO $b) {
            return $a->getDeliveryDateTo()->getTimestamp() - $b->getDeliveryDateTo()->getTimestamp();
        });
    }

    /** @param QuoteDTO[] $quotes */
    private function getTodayFastest(array $quotes): ?QuoteDTO
    {
        if (!isset($quotes[0])) {
            return null;
        }

        $today = new \DateTimeImmutable();
        $firstQuote = $quotes[0];

        if ($firstQuote->getDeliveryDateTo()->format('Ymd') == $today->format('Ymd')) {
            return $firstQuote;
        }

        return null;
    }

    /** @param QuoteDTO[] $quotes */
    private function getTodayEvening(array $quotes): ?QuoteDTO
    {
        foreach ($quotes as $quote) {
            if ($quote->getName() === 'evening') {
                return $quote;
            }
        }

        return null;
    }

    /** @param QuoteDTO[] $quotes */
    private function getLatest(array $quotes): ?QuoteDTO
    {
        $today = new \DateTimeImmutable();

        foreach ($quotes as $quote) {
            if ($quote->getDeliveryDateTo()->format('Ymd') != $today->format('Ymd')) {
                return $quote;
            }
        }

        return null;
    }
}
